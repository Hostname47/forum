<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
use App\Models\{Forum, Thread, ThreadStatus, Category, User, UserReach, SavedThread, ThreadVisibility, Post, Like, Poll, PollOption, NotificationStatement};
use App\View\Components\IndexResource;
use App\View\Components\Thread\{ViewerInfos, ViewerReply, PollOptionComponent};
use App\View\Components\Activities\ActivityThread;
use App\View\Components\Activities\Sections\{Threads, SavedThreads, LikedThreads, RepliedThreads, VotedThreads, ArchivedThreads, ActivityLog};
use App\Scopes\ExcludeAnnouncements;
use App\Classes\NotificationHelper;
use App\Jobs\ExecuteQuery;
use App\Jobs\User\NotifyFollowers;
use Illuminate\Support\Facades\Bus;

class ThreadController extends Controller
{
    public function show(Request $request, $forum, $category, $thread) {
        $thread = Thread::setEagerLoads([])->withoutGlobalScopes()->find(intval($thread));

        if(is_null($thread))
            abort(404); // This will return custom 404 error page

        if(!is_null($thread->deleted_at)) {
            $status = $thread->status->slug;
            if($status == 'deleted-by-owner') // If thread is deleted and status is live means owner delete it normally
                return view('custompages.thread-removed-by-owner');
            else if($status == 'archived') // The thread is archived either because the category or forum is archived
            {
                $category = $thread->category()->withoutGlobalScopes()->first();
                $forum = $category->forum()->withoutGlobalScopes()->first();

                /**
                 * If the thread is archived, that means either category is archived or forum is
                 * archived. We check both category and forum and return an error view based on which
                 * one is archived (category or forum)
                 * Notice that we check forum first because if forum is archived all its categories will be archived
                 * Also notice we end up with abort(404) in case of a bug occured [e.g. archive category but thread within it still live]
                 */
                if($forum->status->slug == 'archived')
                    return view('custompages.thread-archived-due-to-archived-forum')
                        ->with(compact('forum'))
                        ->with(compact('category'));

                if($category->status->slug == 'archived')
                    return view('custompages.thread-archived-due-to-archived-category')
                        ->with(compact('forum'))
                        ->with(compact('category'));
                
                abort(404);
            }

            abort(404);
        }

        $threadowner = $thread->user;
        if($threadowner->status->slug == 'deactivated')
            abort(404);


        $forum = $thread->category->forum;
        $category = $thread->category;
        $ticked = $thread->isticked();
        $missed_ticked_post = false;

        $posts_per_page = 8;
        if(!(Auth::check() && auth()->user()->id == $thread->user_id))
            $thread->update(['view_count'=>$thread->view_count+1]);

        // First we paginate all non-ticked posts
        $posts = $thread->posts()->with(['user'])->where('ticked', 0)->orderBy('created_at', 'desc')->paginate($posts_per_page);

        // Then we look if there is a ticked post; and If user is in first page; If so we prepend the ticked post
        if($ticked 
            && (!$request->has('page') || ($request->has('page') 
            && ($request->get('page') == 0 || $request->get('page') == 1)))) {
            $tickedpost = $thread->tickedPost();
            if($tickedpost)
                $posts->prepend($tickedpost);
            else
                $missed_ticked_post = true;
        }

        // redirect the user to the appropriate page is thread has too many posts
        if(request()->has('reply')) {
            $post = Post::find(request()->get('reply'));
            if(is_null($post) || $post->ticked)
                goto a;
            
            $page = floor($thread->posts()
                ->where('ticked', 0)
                ->orderBy('created_at', 'desc')
                ->where('id', '>=', $post->id)->count() / $posts_per_page) + 1;

            return redirect($thread->link . "?page=" . $page);
        }

        a:

        /**
         * Handling reaching posts by increment reach for each post owner if the visitor has never reach the post
         */
        $currentuser = auth()->user();

        // First get unique posts per user_id
        $reachedposts = $posts->unique('user_id');
        
        // Then exclude the current user if authenticated
        if($currentuser)
            $reachedposts = $reachedposts->where('user_id', '<>', $currentuser->id);

        // Then we loop through posts and handle reach
        foreach($reachedposts as $post) {
            $reach = new UserReach;
            if($currentuser) $reach->reacher = $currentuser->id;
            
            $reach->reachable = $post->user_id;
            $reach->resource_id = $post->id;
            $reach->resource_type = 'App\Models\Post';
            $reach->reacher_ip = $request->ip();

            /**
             * Here let's say the current user already reach this current post, we only save the reach record
             * if the last reach is > 2 days old
             */
            $alreadyreached = UserReach::where('reachable', $post->user_id)
                ->where('resource_id', $post->id)
                ->where('resource_type', 'App\Models\Post')
                ->whereRaw('created_at > \'' . Carbon::now()->subDays(2) . '\'');
            if($currentuser)
                $alreadyreached = (bool) $alreadyreached->where('reacher', $currentuser->id)->count();
            else
                $alreadyreached = (bool) $alreadyreached->where('reacher_ip', $request->ip())->count();

            if(!$alreadyreached)
                $reach->save();
        }

        $totalpostscount = $posts->total() + (($ticked) ? 1 : 0);
        // Useful in post component authorization
        $threadownerid = $thread->user_id;
        // Will be passed to every post components to determine whether user can tick posts or not (improve performence)
        $canbeticked = !$ticked;

        return view('forum.thread.show')
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('posts_per_page'))
            ->with(compact('thread'))
            ->with(compact('ticked'))
            ->with(compact('posts'))
            ->with(compact('missed_ticked_post'))
            ->with(compact('threadownerid'))
            ->with(compact('totalpostscount'));
    }
    public function announcement_show(Request $request, Forum $forum, $announcid) {
        $announcement = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($announcid);
        $owner = $announcement->user;
        $at = (new Carbon($announcement->created_at))->toDayDateTimeString();
        $at_hummans = (new Carbon($announcement->created_at))->diffForHumans();
        $pagesize = 6;

        $announcement->update([
            'view_count'=>$announcement->view_count+1
        ]);

        $tickedPost = $announcement->tickedPost();
        
        if($tickedPost) {
            $posts = $announcement->posts()->where('id', '<>', $tickedPost->id)->orderBy('created_at', 'desc')->paginate($pagesize);
            if(request()->has('page') && request()->get('page') != 1)
                $tickedPost = false;
        } else
            $posts = $announcement->posts()->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('forum.thread.announcement-show')
        ->with(compact('forum'))
        ->with(compact('owner'))
        ->with(compact('posts'))
        ->with(compact('at'))
        ->with(compact('at_hummans'))
        ->with(compact('tickedPost'))
        ->with(compact('announcement'));
    }
    public function create() {
        $this->authorize('create', Thread::class);

        return view('forum.thread.create');
    }
    public function edit(Request $request, User $user, $thread) {
        if($request->has('forceedit'))
            $thread = Thread::withoutGlobalScopes()->find($thread);
        else
            $thread = Thread::find($thread);
        if(!$thread) abort(404);

        $this->authorize('edit', $thread);

        $category = $thread->category;
        $isPoll = $thread->type == 'poll';
        $forum = $category->forum;
        $categories = $forum->categories()->with('status')->excludeannouncements()->get();
        $medias = [];
        if($thread->has_media) {
            $medias_urls = Storage::disk('public')->files('users/' . $user->id . '/threads/' . $thread->id . '/medias');
            foreach($medias_urls as $media) {
                $media_type;
                $media_source = $media;
                $mime = mime_content_type($media);
                if(strstr($mime, "video/")){
                    $media_type = 'video';
                }else if(strstr($mime, "image/")){
                    $media_type = 'image';
                }

                $medias[] = ['frame'=>$media_source, 'type'=>$media_type];
            }
        }

        return view('forum.thread.edit')
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('categories'))
            ->with(compact('medias'))
            ->with(compact('isPoll'))
            ->with(compact('thread'));
    }
    public function store(Request $request) {
        /**
         * Notice that we accept visibility as slug and we'll change it to its associated visibility id later
         */
        $data = request()->validate([
            'type'=>['sometimes', Rule::in(['discussion', 'poll'])],
            'subject'=>'required|min:1|max:1000',
            'content'=>'required|min:1|max:40000',
            'category_id'=>'required|exists:categories,id',
            'visibility_slug'=>'sometimes|exists:thread_visibility,slug',
            'content'=>'required_if:type,discussion|min:2|max:40000',
            'replies_off'=>['required', Rule::in([0, 1])]
        ]);
        $this->authorize('store', [Thread::class, $data]);
        $currentuser = auth()->user();
        $data['user_id'] = $currentuser->id;
        $data['status_id'] = ThreadStatus::where('slug', 'live')->first()->id;

        // Verify if thread visibility is submitted
        if(isset($data['visibility_slug'])) {
            $data['visibility_id'] = ThreadVisibility::where('slug', $data['visibility_slug'])->first()->id;
            unset($data['visibility_slug']);
        }

        // Prevent user from sharing two threads with the same subject in the same category
        $currentuser_threads = $currentuser->threads()->without(['category.forum', 'visibility', 'status', 'user.status']);
        if($duplicate = $currentuser->threads()->withoutGlobalScopes()->setEagerLoads([])
            ->where('subject', $data['subject'])
            ->where('category_id', $data['category_id'])->first()) {

            $duplicate_thread_url = $duplicate->link;
            return response()->json(['error' => __("This title is already exists in your posts list within the same category which is not allowed") . " (<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>" . __('see post') . "</a>), " . __("please choose another title or edit the title of the old post")], 422);
        }

        // If the user add images to thread we have to validate them
        if(request()->has('images')) {
            $validator = Validator::make(
                $request->all(), [
                'images.*' => 'file|mimes:jpg,png,jpeg,gif,bmp|max:12000',
                'images' => 'max:20',
                ],[
                    'images.*.mimes' => __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported'),
                    'images.*.max' => __('Maximum allowed size for an image is 12MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            } else
                $data['has_media'] = 1;
        }
        if(request()->has('videos')) {
            $validator = Validator::make(
                $request->all(), [
                'videos.*' => 'file|mimes:mp4,webm,mpg,mp2,mpeg,mpe,mpv,ogg,mp4,m4p,m4v,avi|max:500000',
                'videos' => 'max:4',
                ],[
                    'videos.*.mimes' => __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported'),
                    'videos.*.max' => __('Maximum allowed size for a video is 500MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            } else
                $data['has_media'] = 1;
        }

        $type = (isset($data['type']) && $data['type'] == 'poll') ? 'poll' : 'typical';
        $polldata;
        $polloptions = [];
        if($type == 'poll') {
            $data['content'] = '..';
            $polldata = $request->validate([
                'allow_multiple_voting'=>[Rule::in([0, 1])],
                'allow_options_add'=>[Rule::in([0, 1])],
                'options_add_limit'=>['required_if:allow_options_add,yes', Rule::in([1, 2, 3])],
            ]);

            // Validate options
            $request->validate([
                'options'=>[
                    'required',
                    function ($attribute, $value, $fail) use (&$polloptions) {
                        $options = json_decode($value); // Parse the json array and take distinct values
                        $uniqueoptions = array_unique(json_decode($value));
                        if(count($options) != count($uniqueoptions))
                            abort(422, __('Poll options must be unique'));

                        $optionlength = count($options);
                        if(!is_array($options))
                            abort(422, __('Poll options must be an array'));
                        if($optionlength < 2)
                            abort(422, __('Poll requires at least 2 options'));
                        if($optionlength > 30)
                            abort(422, __('You could only add 30 options maximum'));

                        $polloptions = $options;
                    }
                ]
            ]);
        }

        // Create the thread
        $thread = Thread::create($data);
        
        // Create poll resources in case thread is a poll
        if($type == 'poll') {
            // Create poll
            $polldata['thread_id'] = $thread->id;
            $poll = Poll::create($polldata);
            // create poll options
            foreach($polloptions as $option) {
                $opt = new PollOption;
                $opt->content = $option;
                $opt->poll_id = $poll->id;
                $opt->user_id = $currentuser->id;

                $opt->save();
            }
        }

        // Create a folder inside thread_owner threads folder with thread id as name
        $path = public_path().'/users/' . $data['user_id'] . '/threads/' . $thread->id;
        File::makeDirectory($path, 0777, true, true);

        // Verify if there's uploaded images
        if(request()->has('images')) {
            foreach($request->images as $image) {
                $image->storeAs(
                    'users/'.$data['user_id'].'/threads/'.$thread->id.'/medias', $image->getClientOriginalName(), 'public'
                );
            }
        }
        // Verify if there's uploaded videos
        if(request()->has('videos')) {
            foreach($request->videos as $video) {
                $video->storeAs(
                    'users/'.$data['user_id'].'/threads/'.$thread->id.'/medias', $video->getClientOriginalName(), 'public'
                );
            }
        }

        $notification =  new \App\Notifications\UserAction([
            'action_user'=>$currentuser->id,
            'action_type'=>'thread-share',
            'resource_id'=>$currentuser->id,
            'resource_type'=>'user', // Read notice below
            'options'=>[
                'canbedisabled'=>true,
                'canbedeleted'=>true,
                'source_type'=>'App\Models\Thread',
                'source_id'=>$thread->id
            ],
            'resource_slice'=>' : ' . $thread->slice,
            'action_statement'=>$type.'-thread-share',
            'link'=>$thread->link,
            'bold'=>$currentuser->minified_name,
            'image'=>$currentuser->sizedavatar(100)
        ]);

        /**
         * ----- Notify followers about the new thread -----
         * 
         * You may be wondering why we place 'user' and $currentuser->id as resource type/id instead of 'thread'/$thread->id
         * Let's say a user share 4 consecutive threads, if the resource_type='thread' and resource_id=$thread->id we
         * gonna end up with 4 distinct notifications about the same user which will result in too many notifications;
         * Instead, we are going to store user id as resource_id and 'user' as resource type just to make it
         * easier for notifications to be fetched distinctly
         */
        Bus::chain([
            new ExecuteQuery(
                "DELETE FROM `notifications` 
                WHERE JSON_EXTRACT(data, '$.action_type')='thread-share' 
                AND JSON_EXTRACT(data, '$.action_user')=$currentuser->id 
                AND JSON_EXTRACT(data, '$.resource_type')='user' 
                AND JSON_EXTRACT(data, '$.resource_id')=$currentuser->id 
                AND read_at IS NOT NULL" // Delete all notification about thread share event of this user THAT ARE ALREADY READ
            ),
            new NotifyFollowers(
                $currentuser, 
                $notification, 
                ['resource_id'=>$currentuser->id, 'resource_type'=>'user', 'action_type'=>'thread-share']
            ),
        ])->dispatch();

        return [
            'link'=>$thread->link,
            'id'=>$thread->id
        ];
    }
    public function update(Request $request, $thread) {
        if($request->has('forceedit'))
            $thread = Thread::withoutGlobalScopes()->find($thread);
        else
            $thread = Thread::find($thread);
        if(!$thread) abort(404);

        $data = request()->validate([
            'subject'=>'sometimes|min:1|max:1000',
            'content'=>'sometimes|min:1|max:40000',
            'replies_off'=>'sometimes|boolean',
            'category_id'=>'sometimes|exists:categories,id',
        ]);
        $newcatid = isset($data['category_id']) ? $data['category_id'] : false;
        $this->authorize('update', [Thread::class, $thread, $newcatid]);
        
        $forum = $thread->category->forum->slug;
        $category = $thread->category->slug;


        if($thread->type == 'poll')
            abort(422, __('Unauthorized action. You cannot update poll informations once shared'));
        // Prevent sharing a thread with the same subject in the same category
        if($duplicate = auth()->user()->threads
            ->where('subject', $data['subject'])
            ->where('category_id', $data['category_id'])
            ->where('id', '<>', $thread->id)->first()) {

            // If same subject within same category found, we simply abort the request with the appropriate erro and return it
            $duplicate_thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicate->id]);
            return response()->json(['error' => __("This title is already exists in your posts list within the same category which is not allowed") . " ( <a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>" . __('see post') . "</a> ), " . __("please choose another title or edit the title of the old post")], 422);
        }

        // If the user add images to thread we have to validate them
        if(request()->has('images')) {
            $validator = Validator::make(
                $request->all(), [
                'images.*' => 'file|mimes:jpg,png,jpeg,gif,bmp|max:12000',
                'images' => 'max:20',
                ],[
                    'images.*.mimes' => __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported'),
                    'images.*.max' => __('Maximum allowed size for an image is 12MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            } else {
                foreach($request->images as $image) {
                    $image->storeAs(
                        'users/' . $thread->user->id . '/threads/' . $thread->id . '/medias', $image->getClientOriginalName(), 'public'
                    );
                }

                $data['has_media'] = 1;
            }
        }
        if(request()->has('videos')) {
            $validator = Validator::make(
                $request->all(), [
                'videos.*' => 'file|mimes:mp4,webm,mpg,mp2,mpeg,mpe,mpv,ogg,mp4,m4p,m4v,avi|max:500000',
                'videos' => 'max:4',
                ],[
                    'videos.*.mimes' => __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported'),
                    'videos.*.max' => __('Maximum allowed size for a video is 500MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            } else {
                foreach($request->videos as $video) {
                    $video->storeAs(
                        'users/' . $thread->user->id . '/threads/' . $thread->id . '/medias', $video->getClientOriginalName(), 'public'
                    );
                }

                $data['has_media'] = 1;
            }
        }

        if($request->has('removed_medias')) {
            // Here we don't have to delete files directly, because we have to check if the deleted files blong to the thread
            $removed_medias_urls = json_decode($request->removed_medias);

            foreach($removed_medias_urls as $media_url) {
                $file_name = basename($media_url);
                /**
                 * Reason is because if thread has 1 image and it is 0.jpg, next time the owner could delete this image
                 * and upload another one and it will get the name 0.jpg; Now the problem is when the user also delete this last one
                 * trash folder already has 0.jpg so we'll get an error. To prevent this we generate a random name for the deleted media
                 */
                $newfilename = md5($file_name . microtime()) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
                $file_path = 'users/' . $thread->user->id . '/threads/' . $thread->id . '/medias/' . $file_name;
                $exists = Storage::disk('public')->exists($file_path);
                
                if($exists) {
                    Storage::disk('public')->move(
                        $file_path, 
                        'users/' . $thread->user->id . '/threads/' . $thread->id . '/trash/' . $newfilename
                    );
                }
            }

            $FileSystem = new Filesystem();
            // Target directory.
            $directory = public_path('users/' . $thread->user->id . '/threads/' . $thread->id . '/medias');

            // Check if the directory exists.
            if ($FileSystem->exists($directory)) {
                // Get all files in this directory.
                $files = $FileSystem->files($directory);

                // Check if media directory is empty.
                if(empty($files)) {
                    $data['has_media'] = 0;  
                }
            }
        }

        $thread->update($data);
        if($request->has('forceedit')) 
            return route('admin.thread.manage') . '?threadid=' . $thread->id;
        return $thread->link;
    }
    public function update_visibility(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'visibility_slug'=>'required|exists:thread_visibility,slug'
        ]);
        
        $thread = Thread::find($data['thread_id']);
        $this->authorize('update', $thread);

        $thread->update([
            'visibility_id'=>ThreadVisibility::where('slug', $data['visibility_slug'])->first()->id
        ]);
    }
    public function delete($thread) {
        $thread = Thread::withoutGlobalScopes()->find($thread);
        $this->authorize('delete', $thread);

        /**
         * Before setting status to deleted by owner, we have to check if the thread is already closed
         */
        $status = ($thread->status->slug == 'closed') ? 'closed-and-deleted-by-owner' : 'deleted-by-owner';
        $thread->update(['status_id'=>ThreadStatus::where('slug', $status)->first()->id]);
        $thread->delete();
        return route('user.activities', ['user'=>auth()->user()->username, 'section'=>'archived-threads']);
    }
    public function destroy(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id'
        ]);
        $thread = Thread::withoutGlobalScopes()->find($data['thread_id']);
        $this->authorize('destroy', [Thread::class, $thread]);

        // deleting related resources is done in boot method on Thread model
        $thread->forceDelete();
    }
    public function restore(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id'
        ]);
        $thread = Thread::withoutGlobalScopes()->find($data['thread_id']);
        $this->authorize('restore', $thread);

        /**
         * Before set status to live we have to check if the thread was already closed
         * If it was already closed and deleted by owner, we set it to closed after restore; otherwise to live
         * Remember that user could not restore thread deleted by an admin
         */
        $status = ($thread->status->slug == 'closed-and-deleted-by-owner') ? 'closed' : 'live';
        $thread->update(['status_id'=>ThreadStatus::where('slug', $status)->first()->id]);
        $thread->restore();

        return $thread->link;
    }
    public function untick_thread(Request $request) {
        $threadid = $request->validate([
            'thread_id'=>'required|exists:threads,id'
        ])['thread_id'];

        $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($threadid);
        $this->authorize('untick_thread', [Thread::class, $thread]);
        
        $thread->posts()->withoutGlobalScopes()->where('ticked', 1)->update(['ticked'=>0]);
    }
    public function fetch_thread_poll_remaining_options(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'skip'=>'required|numeric'
        ]);
        $poll = Poll::where('thread_id', $data['thread_id'])->first();
        $allow_multiple_voting = (bool)$poll->allow_multiple_voting;
        $total_poll_votes = $poll->votes()->count();
        $parent_thread_user_id = \DB::select("SELECT user_id FROM threads WHERE `id`=" . $poll->thread_id)[0]->user_id;
        
        $take = $poll->options()->count() - intval($data['skip']);
        $options = $poll->options()->withCount('votes as votes')->orderBy('votes', 'desc')->skip($data['skip'])->take($take)->get();

        $payload = "";
        foreach($options as $option) {
            $optioncomponent = (new PollOptionComponent($option, (bool)$poll->allow_multiple_voting, $total_poll_votes, $parent_thread_user_id));
            $optioncomponent = $optioncomponent->render(get_object_vars($optioncomponent))->render();
            $payload .= $optioncomponent;
        }

        return [
            'payload'=>$payload,
            'count'=>$options->count()
        ];
    }
    public function fetch_raw_thread_poll_remaining_options(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'skip'=>'required|numeric'
        ]);
        $poll = Poll::where('thread_id', $data['thread_id'])->first();
        $allow_multiple_voting = (bool)$poll->allow_multiple_voting;
        $total_poll_votes = $poll->votes()->count();
        $parent_thread_user_id = \DB::select("SELECT user_id FROM threads WHERE `id`=" . $poll->thread_id)[0]->user_id;
        
        $take = $poll->options()->count() - intval($data['skip']);
        $options = $poll->options()->with(['user'])->withCount('votes as votes')->orderBy('votes', 'desc')->skip($data['skip'])->take($take)->get();

        $payload = "";
        $results = [];
        foreach($options as $option) {
            $votescount = $option->votes()->count();
            $results[] = [
                'addedby_username'=>$option->user->username,
                'addedby_link'=>route('admin.user.manage', ['uid'=>$option->user->id]),
                'content'=>$option->content,
                'votes_count'=>$votescount,
                'vote_percentage'=>($total_poll_votes == 0) ? 0 : floor($votescount * 100 / $total_poll_votes)
            ];
        }

        return $results;
    }
    public function thread_posts_switch(Request $request) {
        
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'action'=>['required', Rule::in(['on','off'])]
        ]);
        $thread = Thread::find($data['thread_id']);
        $this->authorize('update', [Thread::class, $thread]);

        $thread->update([
            'replies_off'=> ($data['action'] == 'on') ? 0 : 1
        ]);

        return [
            'current_replies_state'=> ($data['action'] == 'on') ? 'enabled' : 'disabled'
        ];
    }
    public function thread_save_switch(Request $request, $thread) {
        $thread = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($thread);
        $data = $request->validate([
            'save_switch'=>[
                'required',
                Rule::in(['save', 'unsave']),
            ]
        ]);
        
        if(is_null($thread))
            abort(404, __('Oops something went wrong'));

        $this->authorize('save', [Thread::class, $thread, $data]);

        $currentuser = auth()->user();
        if($data['save_switch'] == 'save') {
            $savedthread = new SavedThread;
            $savedthread->thread_id = $thread->id;
            $savedthread->user_id = $currentuser->id;
            $savedthread->save();

            return 1;
        }
        
        SavedThread::where('thread_id', $thread->id)->where('user_id', $currentuser->id)->delete();
        return -1;
    }
    public function forum_all_threads(Request $request, Forum $forum) {
        $pagesize = 8;
        $tab_title = 'All'; // By default is all, until the user choose other option
        $tab = "all";

        $categories = $forum->categories()->excludeannouncements()->get();

        // First get all forum's categories
        $categories_ids = $categories->pluck('id');
        $threads = Thread::whereIn('category_id', $categories_ids);
        // Fetching forum announcement id to help us get announcements
        $forum_announcement_id = Category::where('slug', 'announcements')->where('forum_id', $forum->id)->first()->id;
        // Fetch announcements of the visited forum
        $announcements = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->where('category_id', $forum_announcement_id)->orderBy('created_at', 'desc')->take(3)->get();

        // Then we fetch all threads in those categories
        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = $threads->today()->orderBy('view_count', 'desc');
                $tab_title = __('Today');
            } else if($tab == 'thisweek') {
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc');
                $tab_title = __('This week');
            }
        }
        $hasmore = $threads->count() > $pagesize ? 1 : 0;
        $threads = $threads->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('forum.category.categories-threads')
        ->with(compact('tab'))
        ->with(compact('tab_title'))
        ->with(compact('forum'))
        ->with(compact('categories'))
        ->with(compact('announcements'))
        ->with(compact('threads'))
        ->with(compact('pagesize'))
        ->with(compact('hasmore'));
    }
    public function category_threads(Request $request, Forum $forum, Category $category) {
        $tab = "all";
        $tab_title = 'All';

        $category = $category;
        $categories = $forum->categories()->excludeannouncements()->get();
        $forums = Forum::all();

        $pagesize = 8;

        $threads = Thread::where('category_id', $category->id);

        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = $threads->today()->orderBy('view_count', 'desc');
                $tab_title = __('Today');
            } else if($tab == 'thisweek') {
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc');
                $tab_title = __('This week');
            }
        }
        $hasmore = $threads->count() > $pagesize ? 1 : 0;
        $threads = $threads->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('forum.category.category-threads')
        ->with(compact('tab'))
        ->with(compact('tab_title'))
        ->with(compact('forum'))
        ->with(compact('forums'))
        ->with(compact('category'))
        ->with(compact('categories'))
        ->with(compact('threads'))
        ->with(compact('pagesize'))
        ->with(compact('hasmore'));
    }
    // --------------- Activity sections and components generating ---------------
    // media viewer infos component
    public function view_infos_component(Request $request, $thread) {
        $thread = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($thread);
        $thread_component = (new ViewerInfos($thread, ['ip'=>$request->ip()]));
        $thread_component = $thread_component->render(get_object_vars($thread_component))->render();

        return $thread_component;
    }
    // range of viewer replies
    public function fetch_more_viewer_posts(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'skip'=>'required|numeric',
        ]);

        $posts_per_fetch = 6;
        $thread = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($data['thread_id']);
        if(!$thread) abort(422, __('Resource not found'));
        $posts = $thread->posts()->with(['user'])->where('ticked', 0)->orderBy('created_at', 'desc')->skip($data['skip'])->take($posts_per_fetch)->get();
        $hasmore = $thread->posts()->count() > $data['skip'] + $posts_per_fetch;

        /**
         * Handling posts reaching
         */
        $reachedposts = $posts->unique('user_id');
        $currentuser = auth()->user();
        if($currentuser)
            $reachedposts = $reachedposts->where('user_id', '<>', $currentuser->id);
        
        foreach($reachedposts as $post) {
            $reach = new UserReach;
            if($currentuser) $reach->reacher = $currentuser->id;
            
            $reach->reachable = $post->user_id;
            $reach->resource_id = $post->id;
            $reach->resource_type = 'App\Models\Post';
            $reach->reacher_ip = $request->ip();

            $alreadyreached = UserReach::where('reachable', $post->user_id)
                ->where('resource_id', $post->id)
                ->where('resource_type', 'App\Models\Post')
                ->whereRaw('created_at > \'' . \Carbon\Carbon::now()->subDays(2) . '\'');
            if($currentuser)
                $alreadyreached = (bool) $alreadyreached->where('reacher', $currentuser->id)->count();
            else
                $alreadyreached = (bool) $alreadyreached->where('reacher_ip', $request->ip())->count();

            if(!$alreadyreached)
                $reach->save();
        }

        $payload = "";
        foreach($posts as $post) {
            $post_component = (new ViewerReply($post, ['thread-owner-id'=>$thread->user_id]));
            $post_component = $post_component->render(get_object_vars($post_component))->render();
            $payload .= $post_component;
        }

        return [
            "hasmore"=> $hasmore,
            "payload"=>$payload,
            "count"=>$posts->count()
        ];
    }
    // sections
    public function generate_section(User $user, $section) {
        
        if( is_null($section) ) {
            abort(422, __('Section is required'));
        }
        
        $sections = ['threads', 'liked-threads', 'voted-threads', 'replied-threads'];
        if(Auth::check() && auth()->user()->id == $user->id) {
            $sections[] = 'saved-threads';
            $sections[] = 'archived-threads';
            $sections[] = 'activity-log';
        }

        if(!in_array($section, $sections)) {
            abort(422, __('Invalide section name'));
        }

        switch($section) {
            case 'threads':
                $threads_section = (new Threads($user));
                return $threads_section->render(get_object_vars($threads_section))->render();
                break;
            case 'saved-threads':
                $saved_threads_section = (new SavedThreads($user));
                return $saved_threads_section->render(get_object_vars($saved_threads_section))->render();
                break;
            case 'liked-threads':
                $liked_threads_section = (new LikedThreads($user));
                return $liked_threads_section->render(get_object_vars($liked_threads_section))->render();
                break;
            case 'replied-threads':
                $replied_threads_section = (new RepliedThreads($user));
                return $replied_threads_section->render(get_object_vars($replied_threads_section))->render();
                break;
            case 'voted-threads':
                $voted_threads_section = (new VotedThreads($user));
                return $voted_threads_section->render(get_object_vars($voted_threads_section))->render();
                break;
            case 'archived-threads':
                $archived_threads = (new ArchivedThreads);
                return $archived_threads->render(get_object_vars($archived_threads))->render();
                break;
            case 'activity-log':
                $activity_logs = (new ActivityLog);
                return $activity_logs->render();
                break;
        }
    }
    // range of section's threads
    public function generate_section_range(Request $request, User $user) {
        $sections = ['threads', 'liked-threads', 'voted-threads', 'replied-threads'];
        if(Auth::check()) {
            if(auth()->user()->id == $user->id) {
                $sections[] = 'saved-threads';
                $sections[] = 'archived-threads';
                $sections[] = 'activity-log';
            }
        }
        $data = $request->validate([
            'section'=>[
                'required',
                Rule::in($sections)
            ],
            'range'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);

        switch($data['section']) {
            case 'threads':
                $threads = $user->threads()->with(['category.status'])->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['range'])->get();

                $payload = "";

                foreach($threads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user, 'thread-posted'));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $user->threads()->count() > $data['skip'] + $data['range'],
                    "content"=>$payload,
                    "count"=>$threads->count()
                ];
                break;
            case 'saved-threads':
                $savedthreads = $user->savedthreads()->skip($data['skip'])->take($data['range'])->get();

                $payload = "";

                foreach($savedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user, 'thread-saved'));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $user->savedthreads()->count() > $data['skip'] + $data['range'],
                    "content"=>$payload,
                    "count"=>$savedthreads->count()
                ];
                break;
            case 'liked-threads':
                $totaluserlikedthreads = $user->likedthreads()->count();
                $likedthreads = $user->likedthreads()->skip($data['skip'])->take($data['range'])->get(); // Skip skip and take range

                $payload = "";
                foreach($likedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user, 'thread-liked'));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $totaluserlikedthreads > $data['skip'] + $likedthreads->count(),
                    "content"=>$payload,
                    "count"=>$likedthreads->count()
                ];
                break;
            case 'replied-threads':
                $totalrepliedthreads = $user->repliedthreadscount;
                $repliedthreads = $user->repliedthreads()->skip($data['skip'])->take($data['range'])->get(); // Skip skip and take range

                $payload = "";
                foreach($repliedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user, 'thread-replied'));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $totalrepliedthreads > $data['skip'] + $repliedthreads->count(),
                    "content"=>$payload,
                    "count"=>$repliedthreads->count()
                ];
                break;
            case 'voted-threads':
                $totaluservotedthreads = $user->votedthreads()->count();
                $votedthreads = $user->votedthreads()->skip($data['skip'])->take($data['range'])->get();

                $payload = "";

                foreach($votedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user, 'thread-voted'));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $totaluservotedthreads > $data['skip'] + $votedthreads->count(),
                    "content"=>$payload,
                    "count"=>$votedthreads->count()
                ];
                break;
            case 'archived-threads':
                $archivedthreads = $user->archivedthreads()->skip($data['skip'])->take(10)->get();
                
                $payload = "";
                foreach($archivedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user, 'thread-archived'));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $user->archivedthreads()->count() >  $data['skip'] + $archivedthreads->count(),
                    "content"=>$payload,
                    "count"=>$archivedthreads->count()
                ];
                break;
            case "activity-log":
                break;
        }
    }
    public function generate_thread_component(Thread $thread) {
        $thread_component = (new IndexResource($thread));
        $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
        return $thread_component;
    }
}

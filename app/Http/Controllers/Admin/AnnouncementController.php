<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
use App\Models\{Forum, Thread, Category, CategoryStatus, User, UserReach, ThreadVisibility, Post, Like, Poll, PollOption};
use App\Scopes\{ExcludeAnnouncements, FollowersOnlyScope};
use App\View\Components\Admin\Announcement\DeleteViewer;

class AnnouncementController extends Controller
{
    public function create(Request $request) {
        $forums = Forum::all();
        return view('admin.announcements.create')
        ->with(compact('forums'));
    }

    public function store(Request $request) {
        $data = $this->validate($request, [
            'type'=>['sometimes', Rule::in(['discussion', 'poll'])],
            'forum_id'=>'required|exists:forums,id',
            'replies_off'=>['sometimes', Rule::in(['1', '0'])],
            'subject'=>'required|min:1|max:1000',
            'content'=>'required_if:type,discussion|min:1|max:40000',
        ], [
            'content.required_if'=>__('Content field is required')
        ]);

        $forum = Forum::find(intval($data['forum_id']));
        $category = Category::where('forum_id', $data['forum_id'])->where('slug', 'announcements')->first();
        $data['category_id'] = $category->id;
        unset($data['forum_id']);
        $this->authorize('create_announcement', [Thread::class]);

        $currentuser = auth()->user();
        $data['user_id'] = $currentuser->id;
        $data['visibility_id'] = ThreadVisibility::where('slug', 'public')->first()->id; // Announcements are always public

        if($duplicate = $currentuser->threads()->withoutGlobalScopes()->where('subject', $data['subject'])->where('category_id', $data['category_id'])->first())
            abort(422, __("The title is already exists in one of your announcements in the same forum which is not allowed. Please choose another title or edit the title of the old post"));

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

            if ($validator->fails())
                abort(422, $validator->errors());
            else
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

            if ($validator->fails())
                abort(422, $validator->errors());
            else
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

        // Create a folder inside thread_owner folder with its id as name
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
        
        return [
            'link'=>route('announcement.show', ['forum'=>$forum->slug, 'announcement'=>$thread->id]),
            'id'=>$thread->id
        ];
    }

    public function manage(Request $request) {
        $pagesize = 8;
        $selectedforum = 'all';
        $forum='';
        if($request->has('forum')) {
            $forum = Forum::where('slug', $request->get('forum'))->first();
            if($forum)
                $selectedforum = $forum->slug;
        }

        $forums = Cache::rememberForever('all-forums', function() {
            return Forum::all();
        });
        
        $announcements = Thread::
            withoutGlobalScope(ExcludeAnnouncements::class)
            ->withoutGlobalScope(FollowersOnlyScope::class)
            ->whereHas('category', function($query) use ($selectedforum, $forum) {
                $query->where('slug', 'announcements');
                if($selectedforum != 'all')
                    $query->where('forum_id', $forum->id);
            })->orderBy('created_at', 'desc')->paginate($pagesize);
            
        return view('admin.announcements.manage')
        ->with(compact('forums'))
        ->with(compact('forum'))
        ->with(compact('selectedforum'))
        ->with(compact('announcements'))
        ;
    }

    public function edit(Request $request, $announcement) {
        $announcement = Thread::
            withoutGlobalScope(ExcludeAnnouncements::class)
            ->withoutGlobalScope(FollowersOnlyScope::class)
            ->find(intval($announcement));
        
        $category = $announcement->category;
        $forum = $category->forum;
        $user = $announcement->user;
        $medias = [];
        if($announcement->has_media) {
            $medias_urls = Storage::disk('public')->files('users/' . $user->id . '/threads/' . $announcement->id . '/medias');
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

        return view('admin.announcements.edit')
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('medias'))
            ->with(compact('announcement'));
    }

    public function update(Request $request, $announcement) {
        $announcement = Thread::
            withoutGlobalScope(ExcludeAnnouncements::class)
            ->withoutGlobalScope(FollowersOnlyScope::class)
            ->find(intval($announcement));

        $forum = $announcement->category->forum->slug;
        $category = $announcement->category->slug;
        
        $data = request()->validate([
            'subject'=>'sometimes|min:2|max:1000',
            'content'=>'sometimes|min:2|max:40000',
            'replies_off'=>'sometimes|boolean',
            'status_id'=>'sometimes|exists:thread_status,id',
        ]);

        $this->authorize('update_announcement', [Thread::class, $announcement]);

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
                        'users/' . $announcement->user->id . '/threads/' . $announcement->id . '/medias', $image->getClientOriginalName(), 'public'
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
                        'users/' . $announcement->user->id . '/threads/' . $announcement->id . '/medias', $video->getClientOriginalName(), 'public'
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
                $file_path = 'users/' . $announcement->user->id . '/threads/' . $announcement->id . '/medias/' . $file_name;
                $exists = Storage::disk('public')->exists($file_path);
                
                if($exists) {
                    Storage::disk('public')->move(
                        $file_path, 
                        'users/' . $announcement->user->id . '/threads/' . $announcement->id . '/trash/' . $file_name
                    );
                }
            }

            $FileSystem = new Filesystem();
            // Target directory.
            $directory = public_path('users/' . $announcement->user->id . '/threads/' . $announcement->id . '/medias');

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
        $announcement->update($data);

        return route('announcement.show', ['forum'=>$forum, 'announcement'=>$announcement->id]);
    }

    public function delete_viewer(Request $request) {
        $data = $request->validate([
            'announcement'=>'required|exists:threads,id'
        ]);

        $announcement = Thread::withoutGlobalScopes()->find($data['announcement']);
        $deleteviewer = (new DeleteViewer($announcement));
        $deleteviewer = $deleteviewer->render(get_object_vars($deleteviewer))->render();

        return $deleteviewer;
    }

    public function delete(Request $request) {
        $data = $request->validate([
            'announcement'=>'required|exists:threads,id'
        ]);
        $announcement = Thread::withoutGlobalScopes()->find($data['announcement']);
        $this->authorize('delete_announcement', $announcement);

        $announcement->forceDelete();
    }
}

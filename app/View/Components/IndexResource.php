<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\{Thread, User, Category, Forum, Follow};
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Markdown;
use FFMpeg;


class IndexResource extends Component
{
    public $thread;
    public $type;
    public $owner;
    public $forum;
    public $category;
    public $content;
    public $ticked;
    // in case the thread is poll
    public $poll;
    public $options;
    public $hasmoreoptions;

    public $allow_multiple_voting;
    public $current_user_could_add_option;
    public $poll_total_votes;
    
    public $edit_link;
    public $category_threads_link;

    public $followed = false;
    public $saved;
    public $views;
    public $likes;
    public $liked;
    
    public $votevalue, $upvoted = false, $downvoted = false; // Voting

    public $replies;
    public $at;
    public $at_hummans;

    public $medias;

    /**
     * $data could take some already evaluated queries result to improve performence.
     * e.g. If thread posts count was already calculated we pass it to data and then
     * check if $data already has posts count or not; If so we use it; otherwise we have
     * to run query to get posts count
     */
    public function __construct(Thread $thread, $data=[]) {
        $this->thread = $thread;
        $this->type = $thread->type;
        $this->owner = $thread->user;
        $this->forum = $thread->category->forum;
        $this->category = $thread->category;
        $this->at = (new Carbon($thread->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
        $this->at_hummans = (new Carbon($thread->created_at))->diffForHumans();
        $this->views = $thread->view_count;
        $this->ticked = isset($data['ticked']) ? $data['ticked'] : $thread->isticked();
        
        $this->replies = isset($data['postscount']) ? $data['postscount'] : $thread->posts()->withoutGlobalScope(\App\Scopes\ExcludeDeactivatedUserData::class)->count();

        if($thread->type == 'poll') {
            $thread->load(['poll']);
            $poll = $thread->poll;
            $this->poll = $poll;

            $options = $poll->options()->with(['user'])->withCount('votes as votes')->orderBy('votes', 'desc')->take(4)->get();
            $poll_options_count = $poll->options()->count(); // This will be used to check hasmore && to check if user is allowed to add options
            $this->options = $options;
            $this->hasmoreoptions = $poll_options_count > 4;
            $this->allow_multiple_voting = (bool) $poll->allow_multiple_voting;
            $this->current_user_could_add_option = auth()->user() 
                && auth()->user()->allowed_to_add_option_on_thread_poll($thread, $poll, ['optionscount'=>$poll_options_count]);
            $this->poll_total_votes = $poll->votes()->count();
        } else
            $this->typestring = 'discussion';
            
        
        $likemanager = $thread->likedandlikescount;
        $this->likes = $likemanager['count'];
        $this->liked = $likemanager['liked'];

        $votemanager = $thread->votedandvotescount;
        $this->votevalue = $votemanager['votevalue'];
        if($votemanager['voted'])
            if($votemanager['uservote'] == 1)
                $this->upvoted = true;
            else
                $this->downvoted = true;

        $content = str_replace('&gt;', '>', $thread->content);
        $content = str_replace("\r\n", "  \n", $content);
        $this->content = Markdown::parse($content);

        $this->saved = $thread->is_saved;

        /**
         * If the thread component is in profile page, we don't want to check follow because
         * we remove follow button from component in profile view page;
         */
        if(\Route::currentRouteName() != 'user.profile') {
            if(Auth::check() && Auth::user()->id != $thread->user_id) {
                $this->followed = 
                    in_array($thread->user_id, \DB::table('follows') // This query get followers ids as array
                    ->select('followable_id')
                    ->where('follower', auth()->user()->id)
                    ->pluck('followable_id')->toArray());
            } else
                $this->followed = false;
        }

        if($this->category->slug == 'announcements')
            $this->edit_link = route('admin.announcements.edit', ['announcement'=>$thread->id]);
        else
            $this->edit_link = route('thread.edit', ['user'=>$thread->user->username, 'thread'=>$thread->id]);
        $this->category_threads_link = route('category.threads', ['forum'=>$this->forum->slug, 'category'=>$this->category->slug]);

        // Thread medias
        if($thread->hasmedias) {
            $medias_links = 
                Storage::disk('public')->files('users/' . $thread->user->id . '/threads/' . $thread->id . '/medias');

            $medias = [];
            foreach($medias_links as $media) {
                $media_type = 'image';
                $media_source = $media;
                $mime = mime_content_type($media);
                if(strstr($mime, "video/")){
                    $media_type = 'video';
                }else if(strstr($mime, "image/")){
                    $media_source = $media;
                }

                $medias[] = ['src'=>$media_source, 'type'=>$media_type, 'mime'=>$mime];
            }
            $this->medias = $medias;
        }
    }
        
    function convert($number)
    {
        if($number < 1000) return $number;
        $suffix = ['','k','M','G','T','P','E','Z','Y'];
        $power = floor(log($number, 1000));
        return round($number/(1000**$power),1,PHP_ROUND_HALF_EVEN).$suffix[$power];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.index-resource', $data);
    }
}

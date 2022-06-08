<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\{Thread};
use Illuminate\Support\Facades\Storage;

class Announcementshow extends Component
{
    public $announcement;
    public $owner;
    public $content;
    public $forum;
    public $likes;
    public $liked;
    public $at;
    public $type;
    public $at_hummans;
    public $medias;
    public $poll;
    public $options;
    public $multiple_choice;
    public $allow_options_creation;
    public $could_add_choice;
    public $poll_total_votes;

    public function __construct(Thread $announcement)
    {
        $this->forum = $announcement->category->forum;
        $this->at = (new Carbon($announcement->created_at))->isoFormat("dddd D MMM YYYY - H:M A");
        $this->at_hummans = (new Carbon($announcement->created_at))->diffForHumans();
        $this->owner = $announcement->user;
        $this->announcement = $announcement;
        $this->type = $announcement->type;
        
        $content = str_replace('&gt;', '>', $announcement->content);
        $content = str_replace("\r\n", "  \n", $content);
        $this->content = \Markdown::parse($content);

        if($announcement->type == 'poll') {
            $announcement->load(['poll']);
            $poll = $announcement->poll;
            $this->poll = $poll;
            $this->options = $poll->options()->with(['user'])->withCount('votes as votes')->orderBy('votes', 'desc')->get();
            $this->multiple_choice = (bool)$poll->allow_multiple_choice;
            $allow_choice_add = (bool)$poll->allow_choice_add;
            $this->allow_options_creation = $allow_choice_add;
            $this->could_add_choice = $allow_choice_add || (auth()->user() && auth()->user()->id == $this->owner->id);
            $this->poll_total_votes = $poll->votes()->count();
        } else
            $this->type = 'discussion';

        if($announcement->has_media) {
            $medias_links = 
                Storage::disk('public')->files('users/' . $announcement->user->id . '/threads/' . $announcement->id . '/medias');

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

                $medias[] = ['frame'=>$media_source, 'type'=>$media_type, 'mime'=>$mime];
            }
            $this->medias = $medias;
        }

        $likemanager = $announcement->likedandlikescount;
        $this->likes = $likemanager['count'];
        $this->liked = $likemanager['liked'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread.announcementshow');
    }
}

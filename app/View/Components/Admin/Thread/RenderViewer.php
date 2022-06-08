<?php

namespace App\View\Components\Admin\Thread;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Storage;

class RenderViewer extends Component
{
    public $thread;
    public $threadowner;
    public $medias;
    public $trashedmedias;
    // In case thread is a poll
    public $options;
    public $hasmoreoptions;
    public $totalpollvotes;

    public function __construct($thread)
    {
        $this->thread = $thread;
        $this->threadowner = $thread->user()->withoutGlobalScopes()->first();
        if($thread->hasmedias) {
            $mediaslinks = Storage::disk('public')->files('users/' . $thread->user_id . '/threads/' . $thread->id . '/medias');
            $medias = [];
            foreach($mediaslinks as $media) {
                $type = 'image';
                $source = $media;
                $mime = mime_content_type($media);
                if(strstr($mime, "video/")) $type = 'video';
                else if(strstr($mime, "image/")) $source = $media;

                $medias[] = ['source'=>$source, 'type'=>$type, 'mime'=>$mime];
            }
            $this->medias = $medias;
        }
        if($thread->hasmediatrash) {
            $trashlinks = Storage::disk('public')->files('users/' . $thread->user_id . '/threads/' . $thread->id . '/trash');
            $trash = [];
            foreach($trashlinks as $media) {
                $type = 'image';
                $source = $media;
                $mime = mime_content_type($media);
                if(strstr($mime, "video/")) $type = 'video';
                else if(strstr($mime, "image/")) $source = $media;

                $trash[] = ['source'=>$source, 'type'=>$type, 'mime'=>$mime];
            }
            $this->trashedmedias = $trash;
        }

        if($thread->type == 'poll') {
            $poll = $thread->poll;
            $options = $poll->options()->withCount('votes as votes')->orderBy('votes', 'desc')->take(5)->get();
            $this->options = $options->take(4);
            $this->hasmoreoptions = $options->count() > 4;
            $this->totalpollvotes = $poll->votes()->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.thread.render-viewer', $data);
    }
}

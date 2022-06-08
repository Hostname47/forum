<?php

namespace App\View\Components\Admin\Post;

use Illuminate\View\Component;
use App\Models\{Report, Post};
use App\Scopes\ExcludeAnnouncements;

class RenderViewer extends Component
{
    public $post;
    public $thread;
    public $postcontent;
    public $postowner;
    public $threadowner;

    public function __construct($post)
    {
        $thread = $post->thread()->withoutGlobalScopes()->first();
        $this->post = $post;
        $this->postowner = $post->user()->withoutGlobalScopes()->first();
        $this->thread = $thread;
        /**
         * Sometimes a reply reported and then the thread owner decide to delete the thread, and therefor when we want to fetch the thread
         * from the post, it will return null. To overcode this case, we prevent users from deleting threads when some report them
         * and inform the thread owner that the admins must check the reports first
         */
        $this->threadowner = $thread->user()->withoutGlobalScopes()->first();

        $postcontent = str_replace('&gt;', '>', $post->mediumcontentslice);
        $postcontent = str_replace("\r\n", "  \n", $postcontent);
        $this->postcontent = \Markdown::parse($postcontent);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.post.render-viewer', $data);
    }
}

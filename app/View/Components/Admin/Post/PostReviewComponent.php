<?php

namespace App\View\Components\Admin\Post;

use Illuminate\View\Component;
use App\Models\Post;

class PostReviewComponent extends Component
{
    public $post;
    public $postowner;

    public $checkuservote;
    
    public function __construct(Post $post, $checkuservote=false)
    {
        $this->post = $post;
        /**
         * Please note the ternary syntax below : sometimes we pass $post along with its owner eager
         * loaded. So if the post has user already eager loaded we simply return it as postowner instead
         * of fetching it again
         */
        $this->postowner = isset($post->user) ? $post->user : $post->user()->withoutGlobalScopes()->first();
        /**
         * if checkuservote(user id passed to it) is supplied, we have to check the post votes
         * and verify if that user with id passed in checkuservote parameter upvoted or downvoted 
         * the post by showing that in viewer
         * 
         * Important: only supply $checkuservote if you are 100% sure that the user passed was already vote the post
         */
        if($checkuservote)
            $this->checkuservote = ($post->upvoted($checkuservote)) ? 1 : -1;
    }

    public function render($data=[])
    {
        return view('components.admin.post.post-review-component', $data);
    }
}

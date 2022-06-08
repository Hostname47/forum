<?php

namespace App\View\Components\Admin\User\Review;

use Illuminate\View\Component;
use App\Models\{Thread, Post};

class ReviewVotesViewer extends Component
{
    public $user;
    public $totalvotescount;
    public $resources;

    public function __construct($user)
    {
        /**
         * Because we're looping over votes and we fetch thread or post votes one by one,
         * then we pass those fetched resources one by one to thread review component/reply review components
         * we end up with too many queries
         * 
         * To solve this, we have to extract all threads ids and posts ids from $votes, 
         * and then we fetch all threads at once and all posts at once, then we use $votes as an indicator
         * to preserve the order of fetched models
         * The point here is that we need to fetch voted threads at once to eager load common relationships
         * (the same thing with voted posts)
         */
        $this->user = $user;
        $this->totalvotescount = $user->votes()->count();
        $votes = $user->votes()->orderBy('created_at', 'desc')->take(10)->get(); // ordered votes
        $threads = Thread::withoutGlobalScopes()
            ->whereIn('id', $votes->where('votable_type', 'App\Models\Thread')->pluck('votable_id'))->get();
        $posts = Post::withoutGlobalScopes()->with('user')
            ->whereIn('id', $votes->where('votable_type', 'App\Models\Post')->pluck('votable_id'))->get();

        $resources = collect([]);
        foreach($votes as $vote) {
            if($vote->votable_type == 'App\Models\Thread') {
                $resources->push($threads->find($vote->votable_id));
            } else if($vote->votable_type == 'App\Models\Post') {
                $resources->push($posts->find($vote->votable_id));
            }
        }

        $this->resources = $resources;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.review.review-votes-viewer', $data);
    }
}

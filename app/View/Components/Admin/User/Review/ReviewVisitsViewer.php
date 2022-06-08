<?php

namespace App\View\Components\Admin\User\Review;

use Illuminate\View\Component;

class ReviewVisitsViewer extends Component
{
    public $user;
    public $visits;
    public $hasmore;

    public function __construct($user)
    {
        $this->user = $user;
        $visits = \DB::select(
            "SELECT `url`, SUM(hits) as hits FROM `visits` 
            WHERE DATE(created_at) = '" . date('Y-m-d') . "' AND visitor_id=$user->id 
            GROUP BY `url` ORDER BY hits DESC LIMIT 11");
        $this->hasmore = count($visits) > 10;
        $this->visits = array_slice($visits, 0, 10);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.review.review-visits-viewer', $data);
    }
}

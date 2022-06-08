<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\PollOption;

class PollOptionComponent extends Component
{
    public $option;
    public $addedby;
    public $multiplevoting;
    public $poll_owner;
    public $voted;
    public $votevalue;
    public $vote_percentage;
    public $int_voted;

    public function __construct(
        PollOption $option, 
        $multiplevoting,
        $totalpollvotes,
        $pollownerid)
        {
            $optionuser = $option->user;
            $this->option = $option;
            $this->addedby = 
                ((auth()->user() && $optionuser->id == auth()->user()->id))
                ? __('you') 
                : '<a href="' . $optionuser->profilelink . '" class="blue no-underline stop-propagation underline-when-hover">' . $option->user->username . "</a>";
            $this->multiplevoting = $multiplevoting;
            $this->poll_owner = auth()->user() && $pollownerid == auth()->user()->id;

            $votedandvotescount = $option->votedandvotescount;
            $this->voted = $votedandvotescount['voted'];
            $this->votevalue = $votedandvotescount['votevalue'];
            
            if($totalpollvotes == 0)
                $this->vote_percentage = 0;
            else
                $this->vote_percentage = floor($votedandvotescount['votevalue'] * 100 / $totalpollvotes);
            $this->int_voted = (int)$votedandvotescount['voted'];
    }

    public function render($data=[])
    {
        return view('components.thread.poll-option-component', $data);
    }
}

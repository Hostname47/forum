<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Poll, PollOption, OptionVote};
use App\View\Components\Thread\PollOptionComponent;
use App\Classes\NotificationHelper;

class PollController extends Controller
{
    public function option_vote(Request $request) {
        $currentuser = auth()->user();
        /** 
         *  Before storing the vote we have to do some checks:
         *  We need to see If the poll of this option is allowing multiple voting or not;
         *       -> If YES; then we do one more check:
         *          ->If the current user already vote this poll; If so we also check if the voted option is the same as the
         *               current option; In that case if they match each other it means the same option and we have to delete
         *               that vote simply. Otherwise if the option voted is not the same as the current option we add the vote.
         *       -> If NO; we do the same checks as above but in case the user already vote the poll, and vote new option,
         *          we remove the previous voted option and save the new one; If the user vote an option and vote it again we simply
         *          remove the vote.
         */
        $optionvote = $request->validate([
            'option_id'=>'required|exists:polloptions,id'
        ]);
        $option = PollOption::find($optionvote['option_id']);
        $this->authorize('option_vote', [Poll::class, $option]);

        $optionvote['user_id'] = $currentuser->id;
        $poll = $option->poll;
        $thread = $poll->thread;
        $threadowner = $thread->user;

        if($poll->allow_multiple_voting) {
            // First check if the option is already voted by the same user
            if($option->voted) {
                // In this case we have to delete the vote
                $poll
                    ->votes()
                    ->where('optionsvotes.user_id', $currentuser->id)
                    ->where('optionsvotes.option_id', $option->id)
                    ->delete();

                $return = [
                    'diff'=>-1,
                    'type'=>'deleted'
                ];
            } else {
                /**
                 * Because users could only add one option to other people polls we still have to delete previous notifications
                 * on that poll, in case where the poll owner delete the added option by the user
                 */
                OptionVote::create($optionvote);
                $return = [
                    'diff'=>1,
                    'type'=>'added'
                ];
            }
        } else {
            // Here the poll owner disable multiple voting
            if($poll->voted) {
                if($option->voted) { // Simply delete option vote if user already vote the same option
                    $poll->votes()
                        ->where('optionsvotes.user_id', $currentuser->id)
                        ->where('optionsvotes.option_id', $option->id)
                        ->delete();

                    $return = [
                        'diff'=>-1,
                        'type'=>'deleted'
                    ];
                } else { // Delete user vote on the poll and add the new one if the user already vote the poll
                    $poll->votes()
                    ->where('optionsvotes.user_id', $currentuser->id)
                    ->delete();

                    OptionVote::create($optionvote);
                    $return = [
                        'diff'=>1,
                        'type'=>'flipped'
                    ];
                }
            } else {
                OptionVote::create($optionvote);
                $return = [
                    'diff'=>1,
                    'type'=>'added'
                ];
            }
        }

        /**
         * At this point, the current user, either vote, unvote or change his choice; and in either case we have to delete
         * previous notification if exists before notifying the thread owner about the vote if the user vote (we don't notify thread owner if the user delete his vote)
         */
        \DB::statement(
            "DELETE FROM `notifications` 
            WHERE JSON_EXTRACT(data, '$.action_type')='poll-vote'
            AND JSON_EXTRACT(data, '$.action_user') = $currentuser->id
            AND JSON_EXTRACT(data, '$.resource_type')='thread' 
            AND JSON_EXTRACT(data, '$.resource_id')=$thread->id"
        );
        
        // Only notify poll owner when vote is added or flipped; and when the threadowner doesn't disable notification on the thread
        $disableinfo = NotificationHelper::extract_notification_disable($threadowner, $thread->id, 'thread', 'poll-vote');
        if($return['type'] != 'deleted' && !$disableinfo['disabled'])
            $this->notify($thread, $threadowner, 'poll-vote', 'poll-vote');

        return $return;
    }

    public function option_delete(Request $request) {
        $data = $request->validate(['option_id'=>'required|exists:polloptions,id']);
        $option = PollOption::find($data['option_id']);

        $this->authorize('option_delete', [Poll::class, $option]);

        $option->delete(); // We delete related items in boot method on the model

        // Should be queued
        \DB::statement(
            "DELETE FROM `notifications` 
            WHERE JSON_EXTRACT(data, '$.action_type')='poll-option-add'
            AND JSON_EXTRACT(data, '$.action_user') = " . $option->user->id .
            " AND JSON_EXTRACT(data, '$.resource_type')='thread' 
            AND JSON_EXTRACT(data, '$.resource_id')=" . $option->poll->thread->id
        );
    }

    public function add_option(Request $request) {
        $currentuser = auth()->user();
        $data = $request->validate([
            'poll_id'=>'required|exists:polls,id',
            'content'=>'required|min:1|max:400'
        ]);
        $poll = Poll::find($data['poll_id']);
        $this->authorize('add_option', [Poll::class, $poll, $data]);

        $data['user_id'] = $currentuser->id;
        $option = PollOption::create($data);
        $thread = $option->poll->thread;
        $threadowner = $thread->user()->withoutGlobalScopes()->setEagerLoads([])->first();

        // The following two statements should be queued
        \DB::statement(
            "DELETE FROM `notifications` 
            WHERE JSON_EXTRACT(data, '$.action_type')='poll-option-add'
            AND JSON_EXTRACT(data, '$.action_user') = " . $currentuser->id .
            " AND JSON_EXTRACT(data, '$.resource_type')='thread' 
            AND JSON_EXTRACT(data, '$.resource_id')=" . $thread->id
        );
        
        // Only notify poll owner If he does not disable notifications about options add on this thread
        $disableinfo = NotificationHelper::extract_notification_disable($threadowner, $thread->id, 'thread', 'poll-option-add');
        if(!$disableinfo['disabled'])
            $this->notify($thread, $threadowner, 'poll-option-add', 'poll-option-add');

        return $option->id;
    }

    public function notify($thread, $threadowner, $action_type, $action_statement) {
        $currentuser = auth()->user();
        if($threadowner->id != $currentuser->id) {
            $threadowner->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>$currentuser->id,
                    'action_type'=>$action_type,
                    'resource_id'=>$thread->id,
                    'resource_type'=>"thread",
                    'options'=>[
                        'canbedisabled'=>true,
                        'canbedeleted'=>true,
                        'source_type'=>'App\Models\Thread',
                        'source_id'=>$thread->id
                    ],
                    'resource_slice'=>' : ' . mb_convert_encoding($thread->slice, 'UTF-8', 'UTF-8'),
                    'action_statement'=>$action_statement,
                    'link'=>$thread->link,
                    'bold'=>$currentuser->minified_name,
                    'image'=>$currentuser->sizedavatar(100)
                ])
            );
        }
    }

    public function get_poll_option_component(PollOption $option) {
        $poll = $option->poll;
        $thread = $poll->thread;
        
        $option_component = new PollOptionComponent(
            $option,
            $poll->allow_multiple_voting,
            $poll->totalvotes,
            $thread->user_id,
        );
        return $option_component->render(get_object_vars($option_component))->render();
    }
}

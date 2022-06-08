<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ContactMessage, Feedback, User};
use App\View\Components\Admin\Contactmessage\Cmessage;
use App\View\Components\Admin\Feedback as FeedbackComponent;

class FeedbackAndMessage extends Controller
{
    public function contactmessages(Request $request) {
        $mpp = 12; // messages per page
        $hasmore = false;
        $contactmessages = ContactMessage::with(['owner'])->orderBy('read')->orderBy('created_at', 'desc')->take($mpp+1)->get();
        $todaymessages = ContactMessage::today()->count();
        $unreadmessages = \DB::select("SELECT COUNT(*) as unreadmessages FROM contact_messages WHERE `read` = 0")[0]->unreadmessages;

        $hasmore = $contactmessages->count() > $mpp;
        $contactmessages = $contactmessages->take($mpp);

        return view('admin.contactmessages')
        ->with(compact('todaymessages'))
        ->with(compact('unreadmessages'))
        ->with(compact('contactmessages'))
        ->with(compact('hasmore'))
        ;
    }

    public function fetch_more_contact_messages(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric|max:100',
            'take'=>'required|numeric|max:100',
        ]);

        $messages = ContactMessage::with(['owner'])->orderBy('read')->orderBy('created_at', 'desc')->skip($data['skip'])->take(intval($data['take']) + 1)->get();
        $hasmore = ($messages->count() > intval($data['take'])) ? true : false;
        $messages = $messages->take(intval($data['take']));
        $authz = [
            'canread'=>auth()->user()->can('mark_contact_message_as_read', [User::class]),
            'candelete'=>auth()->user()->can('delete_contact_message', [User::class])
        ];
        $payload = "";
        foreach($messages as $message) {
            $contactmessage_component = (new Cmessage($message, false, $authz));
            $contactmessage_component = $contactmessage_component->render(get_object_vars($contactmessage_component))->render();
            $payload .= $contactmessage_component;
        }

        return [
            'payload'=>$payload,
            'count'=>$messages->count(),
            'hasmore'=>$hasmore
        ];
    }

    public function fetch_more_feedbacks(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric|max:100',
            'take'=>'required|numeric|max:100',
        ]);

        $feedbacks = Feedback::with(['owner'])->orderBy('created_at', 'desc')->skip($data['skip'])->take(intval($data['take']) + 1)->get();
        $hasmore = ($feedbacks->count() > intval($data['take'])) ? true : false;
        $feedbacks = $feedbacks->take(intval($data['take']));
        $authz = ['candelete'=>auth()->user()->can('delete_feedback', [User::class])];
        $payload = "";
        foreach($feedbacks as $feedback) {
            $feedback_component = (new FeedbackComponent($feedback, $authz));
            $feedback_component = $feedback_component->render(get_object_vars($feedback_component))->render();
            $payload .= $feedback_component;
        }

        return [
            'payload'=>$payload,
            'count'=>$feedbacks->count(),
            'hasmore'=>$hasmore
        ];
    }

    public function mark_message_as_read(Request $request, ContactMessage $message) {
        $this->authorize('mark_contact_message_as_read', [User::class]);
        $message->read = 1;
        $message->save();
    }

    public function mark_all_message_as_read(Request $request) {
        $this->authorize('mark_contact_message_as_read', [User::class]);
        \DB::statement('UPDATE contact_messages SET `read`=1 WHERE true');
    }

    public function mark_messages_group_as_read(Request $request) {
        $this->authorize('mark_contact_message_as_read', [User::class]);
        $data = $request->validate([
            'ids.*'=>'exists:contact_messages,id'
        ]);

        ContactMessage::whereIn('id', $data['ids'])->update(['read'=>1]);
    }

    public function delete_message(Request $request, ContactMessage $message) {
        $this->authorize('delete_contact_message', [User::class]);
        $message->delete();
    }

    public function delete_messages_group(Request $request) {
        $this->authorize('delete_contact_message', [User::class]);
        $data = $request->validate([
            'ids.*'=>'exists:contact_messages,id'
        ]);

        ContactMessage::whereIn('id', $data['ids'])->delete();
    }

    public function delete_feedback(Feedback $feedback) {
        $this->authorize('delete_feedback', [User::class]);
        $feedback->delete();
    }
    
    public function delete_feedbacks_group(Request $request) {
        $this->authorize('delete_feedback', [User::class]);
        $data = $request->validate([
            'ids.*'=>'exists:feedbacks,id'
        ]);

        Feedback::whereIn('id', $data['ids'])->delete();
    }

    public function feedbacks(Request $request) {
        $todayfeedbackscount = \DB::select('SELECT COUNT(*) as total FROM feedbacks WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $emojis = \DB::select('SELECT emoji_feedback, COUNT(*) as count FROM emoji_feedback WHERE DATE(created_at) = \''. date('Y-m-d').'\' GROUP BY emoji_feedback');
        $emojisresult = [
            'sad' => 0,
            'sceptic' => 0,
            'so-so' => 0,
            'happy' => 0,
            'veryhappy' => 0,
        ];
        foreach($emojis as $emoji) {
            $emojisresult[$emoji->emoji_feedback] = $emoji->count;
        }

        $take = 12;
        $feedbacks = Feedback::with(['owner'])->orderBy('created_at', 'desc')->take($take+1)->get();
        $hasmore = $feedbacks->count() > $take;
        $feedbacks = $feedbacks->take($take);

        return view('admin.feedbacks')
        ->with(compact('todayfeedbackscount'))
        ->with(compact('emojisresult'))
        ->with(compact('feedbacks'))
        ->with(compact('hasmore'))
        ;
    }
}

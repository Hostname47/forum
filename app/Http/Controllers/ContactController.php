<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    const RATE_LIMIT = 10;

    public function contactus(Request $request) {
        $rate_limit_reached = false;
        $exceed_rate_limit_message = __("You have a limited number of messages per day") . '.(' . self::RATE_LIMIT . ' ' . __('messages') . ')';

        if(Auth::check()) {
            if(ContactMessage::today()->where('user', auth()->user()->id)->count() >= self::RATE_LIMIT) {
                $rate_limit_reached = true;
            }
        } else {
            if(ContactMessage::today()->where('ip', $request->ip())->count() >= self::RATE_LIMIT) {
                $rate_limit_reached = true;
            }
        }
        return view('contactus')
        ->with(compact('rate_limit_reached'))
        ->with(compact('exceed_rate_limit_message'));
    }

    public function store_contact_message(Request $request) {
        $data;
        if(Auth::check()) {
            $data = $request->validate([
                'company'=>'sometimes|max:100',
                'phone'=>'sometimes|max:80',
                'message'=>'required|min:10|max:2000'
            ]);
            $data['user'] = auth()->user()->id;
        } else
            $data = $request->validate([
                'firstname'=>'required|alpha|max:100',
                'lastname'=>'required|alpha|max:100',
                'email'=>'required|email:rfc,dns|max:400',
                'company'=>'sometimes|max:100',
                'phone'=>'sometimes|max:80',
                'message'=>'required|min:10|max:2000'
            ]);

        /**
         * Notice that we cannot use a policy here because guest users also could send messages
         * IMPORTANT: the authorization must be after validation because user could make 10 requests but all of them are not submitted because of a validation error
         *
         * If the user is authenticated we see if he already sent rate_limit records today; if so we prevent sending
         * If the user is a guest we check the same condition with ip address
         */
        if(Auth::check()) {
            if(ContactMessage::today()->where('user', auth()->user()->id)->count() >= self::RATE_LIMIT) {
                abort(403, __("You have a limited number of messages per day") . '.(' . self::RATE_LIMIT . ' ' . __('messages') . ')');
            }
        } else {
            if(ContactMessage::today()->where('ip', $request->ip())->count() >= self::RATE_LIMIT) {
                abort(403, __("You have a limited number of messages per day") . '(' . self::RATE_LIMIT . ' ' . __('messages') . ')');
            }
        }

        // For data storage limit protection
        if(ContactMessage::today()->count() > 10000)
            abort(403, __("We have received many messages today, If you think your message is too important to review, you can send it to us tomorrow"));
        
        $data['ip'] = $request->ip();

        ContactMessage::create($data);
        \Session::flash('message', __('Your message has been sent successfully') . ' !');
    }
}

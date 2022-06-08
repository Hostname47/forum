<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\{Feedback, EmojiFeedback};

class FeedbackController extends Controller
{
    const RATE_LIMIT = 4;

    public function store(Request $request) {
        /**
         * Here before storing the feedback we have to do some checks
         * Notice that we can't use a policy here because guest users could also provide a feedback
         */
        if(Auth::check()) {
            if(Feedback::today()->where('user_id', auth()->user()->id)->count() >= self::RATE_LIMIT)
                abort(403, __("You have a limited number of messages per day") . '.(' . self::RATE_LIMIT . ' ' . __('messages') . ')');

            /**
             * For now, we let banned users to send feedbacks
             */
            // if(auth()->user()->isBanned())
            //     abort(403, __("Unauthorized action. Your account is currently banned"));
        } else {
            if(Feedback::today()->where('ip', $request->ip())->count() >= self::RATE_LIMIT) {
                abort(403, __("You have a limited number of messages per day") . '.(' . self::RATE_LIMIT . ' ' . __('messages') . ')');
            }
        }

        $data = [];
        if(!auth()->user()) {
            $d = $request->validate([
                'email'=>'required|email:rfc,dns|max:300',
            ]);
            $data['email'] = $d['email'];
            $data['user_id'] = null;

        } else {
            $data['email'] = auth()->user()->email;
            $data['user_id'] = auth()->user()->id;
        }

        $d = $request->validate([
            'feedback'=>'required|min:10|max:800',
        ]);
        $data['feedback'] = $d['feedback'];
        $data['ip'] = $request->ip();

        Feedback::create($data);
    }
    public function store_emojifeedback(Request $request) {
        /**
         * here we do the same thing as with feedback
         */
        if(Auth::check()) {
            if(EmojiFeedback::today()->where('user_id', auth()->user()->id)->count() == 1)
                abort(403, __('You can only give emoji feedback once'));
        } else {
            if(EmojiFeedback::today()->where('ip', $request->ip())->count() == 1)
                abort(403, __('You can only give emoji feedback once'));
        }
        $data = $request->validate([
            'emoji_feedback'=>[
                'required',
                Rule::in(['sad', 'sceptic', 'so-so', 'happy', 'veryhappy']),
            ]
        ]);

        $data['user_id'] = ($u = auth()->user()) ? $u->id : null;
        $data['ip'] = $request->ip();

        EmojiFeedback::create($data);
    }
}

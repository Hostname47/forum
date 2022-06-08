<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountStatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if($user) {
            $accountstatus = $user->status->slug;

            if($accountstatus == 'live')
                return $next($request);
            else if($accountstatus == 'deactivated')
                return redirect()->route('user.account.activate');
            else if($accountstatus == 'banned') {
                // When a user is banned we have to logout this user
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('home')
                    ->with('error', __('Your account has been banned permanently. If you think you get this ban by accident, feel free to contact us'));
            } else if($accountstatus == 'temp-banned') {
                /**
                 * We check if the duration of temporary ban is experid; If so we have to delete ban 
                 * record (soft delete it), and set user account status to live
                 */
                $ban = $user->bans()->orderBy('created_at', 'desc')->where('ban_duration', '<>', -1)->first();
                if(is_null($ban) || $ban->is_expired) {
                    $user->set_account_status('active');
                    $ban->delete();
                }
            } else if($accountstatus == 'deleted') {
                /**
                 * This is the case the user has already deleted his account and try to login again
                 */
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('home')->with('error', __('This account has already been deleted permanently.'));
            }
        }

        return $next($request);
    }
}

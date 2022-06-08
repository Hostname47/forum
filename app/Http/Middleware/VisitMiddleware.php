<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Visit;
use Carbon\Carbon;

class VisitMiddleware
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
        session(['current-url'=>request()->url()]); // Used to redirect user to previous page after login
        
        $visitexists = false;
        if($currentuser=auth()->user())
            $visitexists = $currentuser->visits()->where('created_at', '>', today())->where('url', url()->current())->first();
        else
            $visitexists = Visit::where('visitor_ip', $request->ip())->where('created_at', '>', today())->where('url', url()->current())->first();

        if($visitexists) {
            $visitexists->hits = $visitexists->hits+1;
            $data = json_decode($visitexists->data);
            $data->time[] = date("H:i:s");
            $visitexists->data = json_encode($data);
            $visitexists->save();
        } else {
            $visit = new Visit();
            $visit->visitor_ip = $request->ip();
            if($currentuser=auth()->user())
                $visit->visitor_id = $currentuser->id;
            $visit->url = url()->current();
            $visit->data = json_encode([
                'time'=>[date("H:i:s")]
            ]);
            $visit->save();
        }

        return $next($request);
    }
}

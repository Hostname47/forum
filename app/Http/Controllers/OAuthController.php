<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, UserPersonalInfos, AccountStatus};
use Socialite;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OAuthController extends Controller
{
    /**
  * Redirect the user to the Google authentication page.
  *
  * @return \Illuminate\Http\Response
  */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->with(["prompt" => "select_account"])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        $state = $request->get('state');
        $request->session()->put('state',$state);

        if(Auth::check()==false)
            session()->regenerate();
        
        $u = Socialite::driver($provider)->user();
        $user = User::withoutGlobalScopes()->where('email', $u->email)->first();

        if($user)
            Auth::login($user, true);
        else {
            $names = explode(' ', $u->name);
            // create a new user
            $user = new User;
            $user->firstname = $names[0];
            $user->lastname = (count($names) > 1) ? $names[1] : 'gladiator';
            $user->username = 'gladiator_' . str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
            $user->email = $u->email;
            $user->provider_id = $u->id;
            $user->provider = $provider;
            $user->avatar = NULL;
            $user->provider_avatar = $u->avatar_original;
            $user->account_status = AccountStatus::where('slug', 'active')->first()->id;

            $user->save();
            $user->refresh();

            // Create personal informations row and associate it to user instance
            $personal = UserPersonalInfos::create(['user_id'=>$user->id]);
            
            $user->notify(new \App\Notifications\WelcomeUser());
            $user->notify(new \App\Notifications\FirstSignInPasswordSet());

            Auth::login($user, true);
            \Session::flash('message', __('Welcome to moroccan gladiator forums website. Please check your notifications box'));
            // Then we have to create folders that will hold avatars, covers, threads images ..
            $path = public_path().'/users/' . $user->id;
            File::makeDirectory($path, 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars', 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars/originals', 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars/segments', 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars/trash', 0777, true, true); // Change this 777 because its only for admins
            File::makeDirectory($path.'/usermedia/covers/originals', 0777, true, true);
            File::makeDirectory($path.'/usermedia/covers/trash', 0777, true, true);
            File::makeDirectory($path.'/threads', 0777, true, true);
        }

        if(!is_null($user->deleted_at))
            \Session::flash('error', __('This account has already been deleted permanently.'));

        if(request()->session()->has('current-url'))
            return redirect(session('current-url'));

        return redirect('/home');
    }
}
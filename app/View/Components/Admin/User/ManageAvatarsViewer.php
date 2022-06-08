<?php

namespace App\View\Components\Admin\User;

use Illuminate\View\Component;
use App\Models\{User, WarningReason, StrikeReason};
use Illuminate\Support\Facades\Storage;

class ManageAvatarsViewer extends Component
{
    public $avatars;
    public $trashedavatars;
    public $user;
    public $avatarscount;
    public $defaultavatar;

    public function __construct(User $user)
    {
        $avatars = Storage::disk('public')->files('users/' . $user->id . '/usermedia/avatars/originals');
        $this->trashedavatars = array_reverse(Storage::disk('public')->files('users/' . $user->id . '/usermedia/avatars/trash'));
        
        $c = 0;
        foreach($avatars as $avatar) {
            $avatars[$c] = [
                'avatarlink'=>$avatar,
                'canbemanaged'=>true
            ];
            $c++;
        }

        if($user->provider_avatar)
            if(is_null($user->avatar))
                $avatars[] =  [
                    'avatarlink'=>$user->provider_avatar,
                    'canbemanaged'=>false
                ];
            else
                array_unshift($avatars, [
                    'avatarlink'=>$user->provider_avatar,
                    'canbemanaged'=>false
                ]);
                
        $avatars = array_reverse($avatars); // Reverse the array to get the recent avatars first
        
        $this->avatarscount = (count($avatars)) ? count($avatars) : 1;
        $this->defaultavatar = asset("users/defaults/medias/avatars/avatar.png");
        $this->avatars = $avatars;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.manage-avatars-viewer', $data);
    }
}

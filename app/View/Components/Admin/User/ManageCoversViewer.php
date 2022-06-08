<?php

namespace App\View\Components\Admin\User;

use Illuminate\View\Component;
use App\Models\{User, WarningReason, StrikeReason};
use Illuminate\Support\Facades\Storage;

class ManageCoversViewer extends Component
{
    public $covers;
    public $trashedcovers;
    public $user;
    public $coverscount;
    
    public function __construct(User $user)
    {
        $covers = array_reverse(Storage::disk('public')->files('users/' . $user->id . '/usermedia/covers/originals'));
        
        $this->user = $user;
        $this->covers = $covers;
        $this->coverscount = count($covers);
        $this->trashedcovers = array_reverse(Storage::disk('public')->files('users/' . $user->id . '/usermedia/covers/trash'));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.manage-covers-viewer', $data);
    }
}

<?php

namespace App\View\Components\Admin\Role;

use Illuminate\View\Component;
use App\Models\{User, Role};

class RevokeViewer extends Component
{
    public $user;
    public $role;
    public $hrole;
    public $permissions;
    
    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
        $this->hrole = $user->high_role()->role;
        $this->permissions = $role->permissions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.role.revoke-viewer', $data);
    }
}

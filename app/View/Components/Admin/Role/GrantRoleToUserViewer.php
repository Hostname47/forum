<?php

namespace App\View\Components\Admin\Role;

use Illuminate\View\Component;
use App\Models\{User, Role};

class GrantRoleToUserViewer extends Component
{
    public $user;
    public $role;
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.role.grant-role-to-user-viewer', $data);
    }
}

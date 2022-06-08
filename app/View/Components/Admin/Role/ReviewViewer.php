<?php

namespace App\View\Components\Admin\Role;

use Illuminate\View\Component;
use App\Models\{Role};

class ReviewViewer extends Component
{
    public $role;
    public $spermissions;
    public $users;

    public function __construct(Role $role)
    {
        $this->role = $role;
        $this->spermissions = $role->permissions->groupBy('scope');
        /**
         * Notice that if a member is a super admin, and he does not have admin role, he can do all activities
         * admin could do because super admin role priority is higher than admin role
         */
        $this->users = $role->users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.role.review-viewer', $data);
    }
}

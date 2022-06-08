<?php

namespace App\View\Components\Admin\Permission;

use Illuminate\View\Component;
use App\Models\{Permission, Role};

class ReviewViewer extends Component
{
    public $permission;
    public $roles;
    public $users;

    public function __construct($permission)
    {
        $this->permission = $permission;
        $this->roles = $permission->roles()->orderBy('priority')->get();
        $this->users = $permission->users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.permission.review-viewer', $data);
    }
}

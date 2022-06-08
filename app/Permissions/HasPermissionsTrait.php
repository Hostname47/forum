<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;
use App\Models\UserStatus;
use App\Models\AccountStatus;

trait HasPermissionsTrait {

    public function roles() {
        return $this->belongsToMany(Role::class,'role_user');
    }
    
    public function permissions() {
        return $this->belongsToMany(Permission::class,'permission_user');
    }
    
    /**
     * Keep in mind that If you will call this function on mutiple users for the same role,
     * then you must eager load permissions relationship along with the role so that you'll not end up with
     * running n queries to get permissions of the same role
     */
    public function grant_role($role) {
        // permission could be passed as slug string, or as whole model
        $role = ($role instanceof Role) ? $role : Role::where('slug', $role)->first();
        
        // If the role does not exists or the current user already has it, we stop the flow
        if(is_null($role) || $this->has_role($role->slug)) return false;

        $permissions = $role->permissions;
        // Before grant role, we grant all permissions of that role to user
        $permissions = $role->permissions()->pluck('permission_id');
        $this->permissions()->syncWithoutDetaching($permissions); // Ignore attaching already existing permissions
        // Then we grant role
        $this->roles()->attach($role->id);
    }

    public function revoke_role($role) {
        $role = ($role instanceof Role) ? $role : Role::where('slug', $role)->first();

        if(is_null($role) || !$this->has_role($role->slug)) return false;

        // Detach role permissions
        $permissions = $role->permissions()->pluck('permission_id');
        $this->permissions()->detach($permissions);
        // Detach role
        $this->roles()->detach($role->id);
    }

    public function grant_permission($permission) {
        $permission = ($permission instanceof Permission) ? $permission : Permission::where('slug', $permission)->first();
        if(is_null($permission) || $this->has_permission($permission->slug)) return false;

        $this->permissions()->attach($permission->id);
        return true;
    }

    public function revoke_permission($permission) {
        $permission = ($permission instanceof Permission) ? $permission : Permission::where('slug', $permission)->first();
        if(is_null($permission) || !$this->has_permission($permission->slug)) return false;

        $this->permissions()->detach($permission->id);
        return true;
    }

    public function has_permission($slug) {
        return (bool) $this->permissions()->where('slug', $slug)->count() > 0;
    }

    public function has_role($slug) {
        return (bool) $this->roles()->where('slug', $slug)->count() > 0;
    }

    public function has_status($slug) {
        return $this->status->slug == $slug;
    }

    public function set_account_status($slug) {
        // Here we fetch the account_status based on slug if the slug is not found the status will be set to active (id=1)
        $status = AccountStatus::where('slug', $slug)->first();
        $this->update(['account_status'=>$status->id]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\{Role, Permission, User};
use App\View\Components\Admin\Permission\{ReviewViewer as PReviewViewer};
use App\View\Components\Admin\Role\{ReviewViewer as RReviewViewer, RevokeViewer as RRevokeViewer, GrantRoleToUserViewer};

class RolesAndPermissions extends Controller
{
    public function hierarchy() {
        $high_priority_users = new Collection();

        // First we get all roles
        $roles = Role::orderBy('priority', 'asc')->get();

        $rolesusers = collect([]);
        // Then we loop through roles to get users relationship of each role
        foreach($roles as $role) {
            $high_priority_users = $high_priority_users->merge($role->users);
            $rolesusers[$role->slug] = collect([]);
        }

        /**
         * Notice that the users appended when looping through roles are unique because we are using database collection
         * We get the high role (role with high priority) for each user; for example if a user is super admin, and at the
         * same time an admin; we put that user in super admins collection
         */
        foreach($high_priority_users as $user) {
            $highrole = $user->high_role(); // This will return high priority role the $user has
            $rolesusers->get($highrole->slug)->push($user); // Then we use role slug as key to push that user in collection that hold users with that role
        }

        return view('admin.roles-and-permissions.hierarchy')
        ->with(compact('rolesusers'))
        ->with(compact('roles'));
    }

    public function roles_and_permissions_overview() {
        $roles = Role::orderBy('priority', 'asc')->get();
        $permissions = Permission::all();

        $grouped_permissions = $permissions->groupBy('scope');
        $pscopes = $grouped_permissions->keys();

        return view('admin.roles-and-permissions.overview')
            ->with(compact('roles'))
            ->with(compact('permissions'))
            ->with(compact('grouped_permissions'))
            ->with(compact('pscopes'));
    }

    public function permission_review_viewer(Request $request) {
        $data = $request->validate([
            'pid'=>'required|exists:permissions,id'
        ]);
        $permission = Permission::find($data['pid']);

        $reviewviewer = (new PReviewViewer($permission));
        $reviewviewer = $reviewviewer->render(get_object_vars($reviewviewer))->render();

        return $reviewviewer;
    }

    public function role_review_viewer(Request $request) {
        $data = $request->validate([
            'rid'=>'required|exists:roles,id'
        ]);
        $role = Role::find($data['rid']);

        $reviewviewer = (new RReviewViewer($role));
        $reviewviewer = $reviewviewer->render(get_object_vars($reviewviewer))->render();

        return $reviewviewer;
    }

    // -------------------- Permissions management --------------------

    public function manage_permission_page(Request $request) {
        $scopedpermissions = $users = $roles = collect([]);
        $permissions = Permission::all();
        $permission = null;
        if($request->has('permissionid')) {
            $permission = Permission::find($request->get('permissionid'));
            if($permission) {
                $users = $permission->users;
                $roles = $permission->roles;
            }
        }

        $scopedpermissions = Permission::all()->groupBy('scope');
        $pscopes = $scopedpermissions->keys();

        $cancreate = auth()->user()->can('able_to_create_permission', [Permission::class]);
        $canupdate = auth()->user()->can('able_to_update_permission', [Permission::class]);
        $candelete = auth()->user()->can('able_to_delete_permission', [Permission::class]);
        $can_grant_permission_to_users = auth()->user()->can('able_to_grant_permission_to_users', [Permission::class]);
        $can_revoke_permission_from_users = auth()->user()->can('able_to_revoke_permission_from_users', [Permission::class]);

        return view('admin.roles-and-permissions.manage-permission')
        ->with(compact('scopedpermissions'))
        ->with(compact('permission'))
        ->with(compact('permissions'))
        ->with(compact('pscopes'))
        ->with(compact('users'))
        ->with(compact('roles'))
        ->with(compact('cancreate'))
        ->with(compact('canupdate'))
        ->with(compact('candelete'))
        ->with(compact('can_grant_permission_to_users'))
        ->with(compact('can_revoke_permission_from_users'))
        ;
    }

    public function create_permission(Request $request) {
        $this->authorize('create_permission', [Permission::class]);
        $data = $request->validate([
            'permission'=>'required|min:1|max:255|unique:permissions,permission',
            'slug'=>'required|min:1|max:255|unique:permissions,slug',
            'description'=>'required|min:1|max:2000',
            'scope'=>'required'
        ]);

        $permission = Permission::create($data);
        \Session::flash('message', 'Permission "' . $permission->permission . '" has been created successfully. Now you can attach it to a role or grant it directly to users');
    }

    public function update_permission_informations(Request $request) {
        $this->authorize('update_permission', [Permission::class]);

        $data = $this->validate($request, [
            'pid'=>'required|exists:permissions,id',
            'permission'=>'sometimes|unique:permissions,permission,' . $request->pid,
            'slug'=>'sometimes|unique:permissions,slug,' . $request->pid,
            'description'=>'sometimes|min:1|max:2000'
        ], [
            'permission.unique'=>'Permission name is already exists. Please choose another one',
            'slug.unique'=>'Permission slug is already exists. Please choose another one',
        ]);

        $permission = Permission::find($data['pid']);
        $oldname = $permission->permission;
        unset($data['pid']);
        $permission->update($data);

        \Session::flash('message', 'Permission "' . $oldname . '" informations has been updated successfully.');
    }

    public function search_for_users_to_grant_permission(Request $request) {
        $data = $request->validate([
            'pid'=>'required|exists:permissions,id',
            'k'=>'required|min:1|max:255'
        ]);

        $permission = Permission::find($data['pid']);
        $users = User::withoutGlobalScopes()->orderBy('username')->where('username', 'like', "%" . $data['k'] . "%")->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) use ($permission) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->sizedavatar(100, '-h'),
                'profilelink'=>$user->profilelink,
                'role'=> ($r = $user->high_role()) ? $r->role : null,
                'already_has_this_permission'=>$user->has_permission($permission->slug)
            ];
        });

        return [
            'users'=>$users->take(8),
            'hasmore'=>$hasmore
        ];
    }

    public function fetch_more_users_to_grant_permissions(Request $request) {
        $data = $request->validate([
            'pid'=>'required|exists:permissions,id',
            'skip'=>'required|numeric',
            'k'=>'required|min:1|max:255'
        ]);

        $permission = Permission::find($data['pid']);
        $users = User::withoutGlobalScopes()->orderBy('username')->where('username', 'like', "%" . $data['k'] . "%")->skip($data['skip'])->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) use ($permission) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->sizedavatar(100, '-h'),
                'profilelink'=>$user->profilelink,
                'role'=> ($r = $user->high_role()) ? $r->role : null,
                'already_has_this_permission'=>$user->has_permission($permission->slug)
            ];
        });

        return [
            'users'=>$users->take(8),
            'hasmore'=>$users->count() > 8
        ];
    }

    public function grant_permission_to_users(Request $request) {
        $this->authorize('grant_permission_to_users', [Permission::class]);
        $data = $request->validate([
            'pid'=>'required|exists:permissions,id',
            'users'=>'required',
            'users.*'=>'exists:users,id'
        ]);

        $permission = Permission::find($data['pid']);
        $users = collect($data['users'])->map(function($uid) use ($permission) {
            $user = User::withoutGlobalScopes()->find($uid);
            $user->grant_permission($permission);
            return $user;
        });

        $names = User::mixusersnames($users);
        \Session::flash('message', 'Permission "<span class="blue">' . $permission->permission . '</span>" has been granted to <span class="blue">' . $names . '</span> successfully.');
    }

    public function revoke_permission_from_users(Request $request) {
        $this->authorize('revoke_permission_from_users', [Permission::class]);
        $data = $request->validate([
            'pid'=>'required|exists:permissions,id',
            'users'=>'required',
            'users.*'=>'exists:users,id'
        ]);

        $permission = Permission::find($data['pid']);
        $users = collect($data['users'])->map(function($uid) use ($permission) {
            $user = User::withoutGlobalScopes()->find($uid);
            $user->revoke_permission($permission);
            return $user;
        });

        $names = User::mixusersnames($users);
        \Session::flash('message', 'Permission "<span class="blue">' . $permission->permission . '</span>" has been <span class="red">revoked</span> from <span class="blue">' . $names . '</span> successfully.');
    }

    public function delete_permission(Request $request) {
        $data = $request->validate([
            'permission'=>'required|exists:permissions,id'
        ]);

        $this->authorize('delete_permission', [Permission::class]);
        $permission = Permission::find($data['permission']);

        /**
         * Notice that when a permission deleted, all related roles and users rows will be deleted in cascading
         */
        $permission->delete();

        \Session::flash('message', 'Permission "' . $permission->permission . '" has been deleted successfully with all users/roles detachings.');
        return route('admin.rap.overview');
    }

    // -------------------- Roles management --------------------

    public function manage_role_page(Request $request) {
        $roles = $users = $role_scoped_permissions = $all_permissions_scoped = collect([]);
        $role = null;
        $canadd = auth()->user()->can('able_to_create_role', [Role::class]);
        $canupdate = auth()->user()->can('able_to_update_role', [Role::class]);
        $can_grant_role_to_user = auth()->user()->can('able_to_grant_role_to_user', [Role::class]);
        $can_revoke_role_from_user = auth()->user()->can('able_to_revoke_role_from_user', [Role::class]);
        $can_attach_permissions_to_role = auth()->user()->can('able_to_attach_permissions_to_role', [Role::class]);
        $can_detach_permissions_from_role = auth()->user()->can('able_to_detach_permissions_from_role', [Role::class]);
        $can_delete_role = auth()->user()->can('able_to_delete_role', [Role::class]);
        if($request->has('roleid')) {
            $role = Role::find($request->get('roleid'));
            if($role) {
                $users = $role->users;
                $role_scoped_permissions = $role->permissions->groupBy('scope');
                // In the following, we eager load roles, to prevent querying permission roles relationship
                // on each permission because we'll check if the permission already attached to role or not (avoid N+1 issue)
                $all_permissions_scoped = Permission::with('roles')->get()->groupBy('scope');
            }
        }
        $roles = Role::orderBy('priority')->get();

        return view('admin.roles-and-permissions.manage-role')
        ->with(compact('role'))
        ->with(compact('canadd'))
        ->with(compact('canupdate'))
        ->with(compact('can_grant_role_to_user'))
        ->with(compact('can_revoke_role_from_user'))
        ->with(compact('can_attach_permissions_to_role'))
        ->with(compact('can_detach_permissions_from_role'))
        ->with(compact('can_delete_role'))
        ->with(compact('users'))
        ->with(compact('all_permissions_scoped'))
        ->with(compact('role_scoped_permissions'))
        ->with(compact('roles'));
    }

    public function create_role(Request $request) {
        $this->authorize('create_role', [Role::class]);
        $data = $request->validate([
            'role'=>'required|min:1|max:255|unique:roles,role',
            'slug'=>'required|min:1|max:255|unique:roles,slug',
            'description'=>'required|min:1|max:2000'
        ]);

        /**
         * First we have to get max priority value and add 1, to attach to the created role the lowest priority value
         * Remember the highest priority column is, the lowest priveleges you will have (e.g. priority=1 is for super admin with no restrictions)
         */
        $lowest_priority = \DB::select("SELECT MAX(priority) as maxpriority FROM roles")[0]->maxpriority + 1;
        $data['priority'] = $lowest_priority;
        Role::create($data);

        \Session::flash('message', 'Role "' . $data['role'] . '" has been created successfully. Now you can attach some permissions to that role and give it to users');
        return route('admin.rap.overview');
    }

    public function update_role_informations(Request $request) {
        $this->authorize('update_role', [Role::class]);

        $data = $this->validate($request, [
            'rid'=>'required|exists:roles,id',
            'role'=>'sometimes|unique:roles,role,' . $request->rid,
            'slug'=>'sometimes|unique:roles,slug,' . $request->rid,
            'description'=>'sometimes|min:1|max:2000'
        ], [
            'role.unique'=>'Role name is already exists. Please choose another one',
            'slug.unique'=>'Role slug is already exists. Please choose another one',
        ]);

        $role = Role::find($data['rid']);
        $oldname = $role->role;
        unset($data['rid']);
        $role->update($data);

        \Session::flash('message', 'Role "' . $oldname . '" informations has been updated successfully.');
    }

    public function search_for_users_to_grant_role(Request $request) {
        $data = $request->validate([
            'rid'=>'required|exists:roles,id',
            'k'=>'required|min:1|max:255'
        ]);

        $role = Role::find($data['rid']);
        $users = User::withoutGlobalScopes()->where('username', 'like', "%" . $data['k'] . "%")->take(9)->get();

        $users = $users->map(function($user) use ($role) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->sizedavatar(100, '-h'),
                'profilelink'=>$user->profilelink,
                'role'=> ($r = $user->high_role()) ? $r->role : null,
                'already_has_this_role'=>$user->has_role($role->slug)
            ];
        });

        return [
            'users'=>$users->take(8),
            'hasmore'=>$users->count() > 8
        ];
    }

    public function fetch_more_users_to_grant_role(Request $request) {
        $data = $request->validate([
            'rid'=>'required|exists:roles,id',
            'skip'=>'required|numeric',
            'k'=>'required|min:1|max:255'
        ]);

        $role = Role::find($data['rid']);
        $users = User::withoutGlobalScopes()->where('username', 'like', "%" . $data['k'] . "%")->skip($data['skip'])->take(9)->get();

        $users = $users->map(function($user) use ($role) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->sizedavatar(100, '-h'),
                'profilelink'=>$user->profilelink,
                'role'=> ($r = $user->high_role()) ? $r->role : null,
                'already_has_this_role'=>$user->has_role($role->slug)
            ];
        });

        return [
            'users'=>$users->take(8),
            'hasmore'=>$users->count() > 8
        ];
    }

    public function grant_role_to_users(Request $request) {
        $this->authorize('grant_role_to_user', [Role::class]);
        $data = $request->validate([
            'rid'=>'required|exists:roles,id',
            'users'=>'required',
            'users.*'=>'exists:users,id'
        ]);

        /**
         * granting a role to a user means we grant all permissions of role to the user and then give it
         * role just as a label (If a user has a role, that does not necessarily mean it has all permissions that are belong to
         * that role). It is not necessary that if a user has a role means it must has all permissions in that role
         * because permissions could be revoked
         */
        $role = Role::find($data['rid']);
        $users = collect($data['users'])->map(function($uid) use ($role) {
            $user = User::withoutGlobalScopes()->find($uid);
            $user->grant_role($role);
            return $user;
        });

        $names = User::mixusersnames($users);
        \Session::flash('message', 'Role "<span class="blue">' . $role->role . '</span>" has been granted to <span class="blue">' . $names . '</span> successfully.');
    }

    public function revoke_role_from_user(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'user'=>'required|exists:users,id',
        ]);

        $role = Role::find($data['role']);
        $user = User::withoutGlobalScopes()->find($data['user']);
        $this->authorize('revoke_role_from_user', [Role::class, $role, $user]);
        
        $user->revoke_role($role);
        \Session::flash('message', 'Role "<span class="blue">' . $role->role . '</span>" has been <span class="red">revoked</span> from <span class="blue">' . $user->username . '</span> successfully.');
    }

    public function attach_permissions_to_role(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id'
        ]);
        $this->authorize('attach_permissions_to_role', [Role::class]);

        $role = Role::find($data['role']);
        
        $role->permissions()->syncWithoutDetaching($data['permissions']);
        // After attaching permissions to role, we have to grant those permissions to role users
        foreach($role->users as $user) {
            $user->permissions()->syncWithoutDetaching($data['permissions']);
        }

        \Session::flash('message', 'Permission(s) attached successfully to "' . $role->role . '" role.');
    }

    public function detach_permissions_from_role(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id'
        ]);
        $this->authorize('detach_permissions_from_role', [Role::class]);

        $role = Role::find($data['role']);
        $role->permissions()->detach($data['permissions']);

        foreach($role->users as $user) {
            $user->permissions()->detach($data['permissions']);
        }

        \Session::flash('message', 'Permission(s) detached successfully from "' . $role->role . '" role.');
    }

    public function delete_role(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id'
        ]);

        $this->authorize('delete_role', [Role::class]);
        $role = Role::find($data['role']);
        $users = $role->users()->with('roles')->get(); // Role members (we'll use high_role which will look for higher role of each user; that's why we eager load roles)
        $permissions = $role->permissions()->pluck('permission_id'); // Permissions associated to this role

        /**
         * Before deleting the role, we need to take all permissions attached to it from all users with that role
         * Important:
         *  If a user has a high priority role along with this role, the permissions of that role will not be detached in this case
         *  we only detach permissions from members that they have this role as their high priority role
         *  If a user does not have this role but he got some of the permissions attached to this role, will not
         *  lose those permissions
         */
        foreach($users as $user) {
            if($user->high_role()->id == $role->id)
                $user->permissions()->detach($permissions);
        }

        $role->delete();

        \Session::flash('message', 'Role "' . $role->role . '" has been deleted successfully with all user/permissions detachings.');
        return route('admin.rap.overview');
    }

    // -------------------- User roles & permissions management --------------------
    
    public function manage_user_roles_and_permissions(Request  $request) {
        $user = null;
        $roles = $spermissions = $allroles = $allspermissions = collect([]);
        $can_grant_role_to_user = $can_revoke_role_from_user = $can_grant_permission_to_user = $can_revoke_permission_from_user = false;
        if($request->has('uid')) {
            $can_grant_role_to_user = auth()->user()->can('able_to_grant_role_to_user', [Role::class]);
            $can_revoke_role_from_user = auth()->user()->can('able_to_revoke_role_from_user', [Role::class]);
            $can_grant_permission_to_user = auth()->user()->can('able_to_grant_permission_to_users', [Permission::class]);
            $can_revoke_permission_from_user = auth()->user()->can('able_to_revoke_permission_from_users', [Permission::class]);
            $user = User::withoutGlobalScopes()->find($request->get('uid'));
            if($user) {
                $roles = $user->roles->sortBy('priority');
                $spermissions = $user->permissions->groupBy('scope');

                $allroles = Role::all()->sortBy('priority');
                $allspermissions = Permission::with('users')->get()->groupBy('scope');
            }
        }
        return view('admin.roles-and-permissions.manage-user-roles-and-permissions')
            ->with(compact('user'))
            ->with(compact('roles'))
            ->with(compact('allroles'))
            ->with(compact('allspermissions'))
            ->with(compact('spermissions'))
            ->with(compact('can_grant_role_to_user'))
            ->with(compact('can_revoke_role_from_user'))
            ->with(compact('can_grant_permission_to_user'))
            ->with(compact('can_revoke_permission_from_user'))
            ;
    }

    public function search_for_users_to_manage_rap(Request $request) {
        $data = $request->validate([
            'k'=>'required|min:1|max:255'
        ]);

        $users = User::withoutGlobalScopes()->where('username', 'like', "%" . $data['k'] . "%")->orderBy('username')->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) {
            return [
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->sizedavatar(100, '-h'),
                'role'=> ($r = $user->high_role()) ? $r->role : null,
                'managelink'=>route('admin.rap.manage.user') . '?uid=' . $user->id,
            ];
        });

        return [
            'users'=>$users,
            'hasmore'=>$hasmore
        ];
    }

    public function fetch_more_users_to_manage_rap(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric',
            'k'=>'required|min:1|max:255'
        ]);

        $users = User::withoutGlobalScopes()->orderBy('username')->where('username', 'like', "%" . $data['k'] . "%")->skip($data['skip'])->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) {
            return [
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->sizedavatar(100, '-h'),
                'role'=> ($r = $user->high_role()) ? $r->role : null,
                'managelink'=>route('admin.rap.manage.user') . '?uid=' . $user->id,
            ];
        });

        return [
            'users'=>$users,
            'hasmore'=>$hasmore
        ];
    }

    public function grant_permissions_to_user(Request $request) {
        $data = $request->validate([
            'user'=>'required|exists:users,id',
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id'
        ]);

        $this->authorize('grant_permission_to_users', [Permission::class]);
        $user = User::withoutGlobalScopes()->find($data['user']);

        $user->permissions()->syncWithoutDetaching($data['permissions']);
        \Session::flash('message', count($data['permissions']) . ' permission' . ((count($data['permissions']) > 1) ? 's' :'') . ' granted successfully to "<span class="blue">' . $user->username . '</span>"');
    }

    public function revoke_permissions_from_user(Request $request) {
        $data = $request->validate([
            'user'=>'required|exists:users,id',
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id'
        ]);

        $this->authorize('revoke_permission_from_users', [Permission::class]);
        $user = User::withoutGlobalScopes()->find($data['user']);

        $user->permissions()->detach($data['permissions']);
        \Session::flash('message', count($data['permissions']) . ' permission' . ((count($data['permissions']) > 1) ? 's' :'') . ' <span class="red">detached</span> successfully from "<span class="blue">' . $user->username . '</span>"');
    }

    public function grant_role_to_user_viewer(Request $request) {
        $data = $request->validate([
            'user'=>'required|exists:users,id',
            'role'=>'required|exists:roles,id',
        ]);

        $user = User::withoutGlobalScopes()->find($data['user']);
        $role = Role::find($data['role']);
        
        $grantviewer = (new GrantRoleToUserViewer($user, $role));
        $grantviewer = $grantviewer->render(get_object_vars($grantviewer))->render();

        return $grantviewer;
    }

    public function revoke_role_from_user_viewer(Request $request) {
        $data = $request->validate([
            'rid'=>'required|exists:roles,id',
            'uid'=>'required|exists:users,id'
        ]);
        $role = Role::find($data['rid']);
        $user = User::withoutGlobalScopes()->find($data['uid']);

        $reviewviewer = (new RRevokeViewer($role, $user));
        $reviewviewer = $reviewviewer->render(get_object_vars($reviewviewer))->render();

        return $reviewviewer;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Role, User};

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    // Roles that the current permission attached to
    public function roles() {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'permission_user')->withoutGlobalScopes();
    }

    public function already_attached_to_role($roleslug) {
        return (bool) $this->roles->where('slug', $roleslug)->count() > 0;
    }

    public function already_attached_to_user($username) {
        return (bool) $this->users->where('username', $username)->count() > 0;
    }
}

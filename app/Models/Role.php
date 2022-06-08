<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Permission};

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    
    public function users() {
        return $this->belongsToMany(User::class, 'role_user')->withoutGlobalScopes();
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function getDescriptionsliceAttribute() {
        return strlen($this->description) > 100 ? substr($this->description, 0, 100) . '..' : $this->description;
    }

    public function permission_already_attached($slug) {
        return (bool) $this->permissions()->where('slug', $slug)->count() > 0;
    }
}

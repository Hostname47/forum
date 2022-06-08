<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExcludeDeactivatedUserData;
use App\Models\User;

class Like extends Model
{
    use HasFactory;

    protected $table = "likes";
    protected $guarded = [];

    public function likable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

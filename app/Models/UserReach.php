<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReach extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "user_reach";

    public function scopeToday($builder)
    {
        return $builder->where('created_at', '>', today());
    }
}

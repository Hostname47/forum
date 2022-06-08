<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "follows";

    public function commentable()
    {
        return $this->morphTo();
    }
}

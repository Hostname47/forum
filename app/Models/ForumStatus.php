<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forum;

class ForumStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "forum_status";

}

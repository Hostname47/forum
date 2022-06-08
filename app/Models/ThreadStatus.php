<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thread;

class ThreadStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'thread_status';
}

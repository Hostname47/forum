<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloseReason extends Model
{
    use HasFactory;
    protected $table = 'closereasons';
    protected $guarded = [];
}

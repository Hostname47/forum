<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarningReason extends Model
{
    use HasFactory;

    protected $table = 'warning_reasons';
    protected $guarded = [];
}

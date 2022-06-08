<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmojiFeedback extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'emoji_feedback';

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }
}

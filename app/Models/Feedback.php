<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Feedback extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'feedbacks';

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getSliceAttribute() {
        return strlen($this->feedback) > 180 ? substr($this->feedback, 0, 180) . '..' : $this->feedback;
    }

    public function getMediumsliceAttribute() {
        return strlen($this->feedback) > 300 ? substr($this->feedback, 0, 300) . '..' : $this->feedback;
    }
}

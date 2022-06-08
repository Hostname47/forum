<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FAQ extends Model
{
    use HasFactory;

    protected $table = "faqs";
    protected $guarded = [];

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getQuestionsliceAttribute() {
        return strlen($this->question) > 20 ? substr($this->question, 0, 20) . '..' : $this->question;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ContactMessage extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'contact_messages';

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function getSliceAttribute() {
        return strlen($this->message) > 180 ? substr($this->message, 0, 180) . '..' : $this->message;
    }

    public function getMediumsliceAttribute() {
        return strlen($this->message) > 300 ? substr($this->message, 0, 300) . '..' : $this->message;
    }
}

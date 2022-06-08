<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{CloseReason, User};

class ThreadClose extends Model
{
    use HasFactory;

    protected $table = 'threadcloses';
    protected $guarded = [];

    public function reason() {
        return $this->belongsTo(CloseReason::class);
    }

    public function closedby() {
        return $this->belongsTo(User::class, 'closed_by');
    }
}

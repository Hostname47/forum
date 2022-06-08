<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PollOption;

class OptionVote extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'optionsvotes';

    public function option() {
        return $this->belongsTo(PollOption::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StrikeReason;
use Carbon\Carbon;

class Strike extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reason() {
        return $this->belongsTo(StrikeReason::class);
    }

    public function getAthummansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getStrikedateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }
}

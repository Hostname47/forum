<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WarningReason;
use Carbon\Carbon;

class Warning extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getAthummansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getWarningdateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function reason() {
        return $this->belongsTo(WarningReason::class, 'reason_id');
    }
}

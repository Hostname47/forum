<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NotificationDisable extends Model
{
    use HasFactory;

    protected $table = 'notificationsdisables';

    public function getDisabledAtHummansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getDisabledAtAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }
}

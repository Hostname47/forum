<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{AuthBreakType, User};
use Carbon\Carbon;

class Authorizationbreak extends Model
{
    use HasFactory;

    public function breaktype() {
        return $this->belongsTo(AuthBreakType::class, 'type');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getAthummansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getBreakdateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

}

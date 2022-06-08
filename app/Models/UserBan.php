<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{BanReason, User};
use Carbon\Carbon;

class UserBan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'bans';

    public function reason() {
        return $this->belongsTo(BanReason::class, 'ban_reason');
    }

    // Get the admin who ban
    public function bannedby() {
        return $this->belongsTo(User::class, 'admin_id')->withoutGlobalScopes();
    }

    public function getTimeremainingAttribute($value) {
        $now = Carbon::now()->timestamp;
        $deadline = $this->created_at->addDays($this->ban_duration)->timestamp;
        $timeremaining = $deadline - $now;

        $months = floor($timeremaining/2592000);
        $days = floor(($timeremaining%2592000)/86400);
        $hours = floor(($timeremaining%86400)/3600);
        
        $timeremaining = "";
        if($months) 
            $timeremaining .= $months . ' ' . __('months') . ' ';
        if($days) {
            if($months) $timeremaining .= __('and') . ' ';
            $timeremaining .= $days . ' ' . __('days') . ' ';
        }
        if($hours) {
            if($days) $timeremaining .= __('and') . ' ';
            $timeremaining .= $hours . ' ' . __('hours');
        }

        return trim($timeremaining);
    }

    public function getBanDurationHummansAttribute() {
        $bandate = $this->created_at->timestamp;
        $deadline = $this->created_at->addDays($this->ban_duration)->timestamp;
        $duration = $deadline - $bandate;

        $months = floor($duration/2592000);
        $days = floor(($duration%2592000)/86400);
        $hours = floor(($duration%86400)/3600);
        
        $duration = "";
        if($months) 
            $duration .= $months . ' ' . __('months') . ' ';
        if($days) {
            if($months) $duration .= __('and') . ' ';
            $duration .= $days . ' ' . __('days') . ' ';
        }
        if($hours) {
            if($days) $duration .= __('and') . ' ';
            $duration .= $hours . ' ' . __('hours');
        }

        return trim($duration);
    }
    public function getFormateddurationAttribute() {
        $duration = $this->ban_duration * 86400;

        $months = floor($duration/2592000);
        $days = floor(($duration%2592000)/86400);
        $hours = floor(($duration%86400)/3600);
        
        $duration = "";
        if($months) 
            $duration .= $months . ' ' . __('months') . ' ';
        if($days) {
            if($months) $duration .= __('and') . ' ';
            $duration .= $days . ' ' . __('days') . ' ';
        }
        if($hours) {
            if($days) $duration .= __('and') . ' ';
            $duration .= $hours . ' ' . __('hours');
        }

        return trim($duration);
    }
    public function getBandateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }
    public function getExpiredatAttribute() {
        return (new Carbon($this->created_at))->addDays($this->ban_duration)->isoFormat("dddd D MMM YYYY - H:mm A");
    }
    public function getIsExpiredAttribute() {
        $now = Carbon::now()->timestamp;
        $deadline = $this->created_at->addDays($this->ban_duration)->timestamp;
        return  $now - $deadline > 0;
    }
}

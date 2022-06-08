<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reportable()
    {
        return $this->morphTo();
    }
    
    public function scopeToday($builder){
        return $builder->where('created_at', '>=', today());
    }

    public function reporteruser() {
        return $this->belongsTo(User::class, 'reporter')->withoutGlobalScopes();
    }

    public function reporter_already_warned_about_this_report() {
        return $this->reporteruser->warnings()->where('resource_id', $this->id)->where('resource_type', 'App\Models\Report')->count() > 0;
    }

    public function reporter_already_striked_about_this_report() {
        return $this->reporteruser->strikes()->where('resource_id', $this->id)->where('resource_type', 'App\Models\Report')->count() > 0;
    }

    public function getAthummansAttribute() {
        return (new \Carbon\Carbon($this->created_at))->diffForHumans();
    }

    public function getCreationdateAttribute() {
        return (new \Carbon\Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getMessageSliceAttribute() {
        return strlen($this->body) > 80 ? substr($this->body, 0, 80) . '..' : $this->body;
    }
}

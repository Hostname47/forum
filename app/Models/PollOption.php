<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Poll,User,OptionVote};

class PollOption extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'polloptions';
    public $with = ['user'];

    public static function boot() {
        parent::boot();

        static::deleting(function($option) {
            $option->votes()->delete();
        });
    }

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function votes() {
        return $this->hasMany(OptionVote::class, 'option_id');
    }

    public function getVotedandvotescountAttribute() {
        if($currentuser=auth()->user())
            $query = "SELECT COUNT(*) as votevalue, SUM(user_id = $currentuser->id) as voted FROM optionsvotes WHERE option_id=?";
        else
            $query = "SELECT COUNT(*) as votevalue, 0 as voted FROM optionsvotes WHERE option_id=?";

        $result = \DB::select($query, [$this->id]);
        return [
            'votevalue'=>$result[0]->votevalue,
            'voted'=>$result[0]->voted,
        ];
    }

    public function getVotedAttribute() {
        if(($currentuser = auth()->user()))
            return $this->votes()->where('user_id', $currentuser->id)->count() > 0;

        return false;
    }
}

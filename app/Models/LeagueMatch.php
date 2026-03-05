<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMatch extends Model
{
    protected $fillable = [
        'group_id',
        'team1_id',
        'team2_id',
        'team1_score',
        'team2_score',
        'round'
    ];

    // リーグ戦のグループ
    public function team1() {
       return $this->belongsTo(Team::class,'team1_id');
    }

    public function team2() {
       return $this->belongsTo(Team::class,'team2_id');
    }
}

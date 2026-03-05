<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Team extends Model
{

    protected $fillable = [
        'team_name',
        'class',
        'group_id',
        'representative_id',
        ];

    // 1対１（team→representative)
    public function representative() {
       return $this->belongsTo(Representative::class);
    }

    // 1対多（team→member)
    public function members() {
       return $this->hasMany(TeamMember::class);
    }

    // 1対1（team→group)
    public function group() {
       return $this->belongsTo(Group::class);
    }

    public function leagueMatch1() {
       return $this->hasMany(LeagueMatch::class,'team1_id');
    }

    public function LeagueMatch2() {
       return $this->hasMany(LeagueMatch::class,'team2_id');
    }
}

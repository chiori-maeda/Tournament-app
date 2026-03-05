<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    protected $fillable = ['class', 'name'];

    // 1対多 （group→team）
    public function teams() {
       return $this->hasMany(Team::class);
    }

    public function leagueMatches() {
        return $this->hasMany(LeagueMatch::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    
protected $fillable = ['name','address','phone','email'];

public function teams() {
    return $this->hasMany(Team::class);
}
}

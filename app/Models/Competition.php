<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    public function seasons(){
        return $this->belongsToMany(Season::class,'competitions_seasons');
    }

    public function games(){
        return $this->hasMany(Game::class);
    }
}

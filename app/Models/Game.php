<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function players(){
        return $this->belongsToMany(Player::class,'games_players');
    }

    public function teams(){
        return $this->belongsToMany(Team::class,'games_teams');
    }

    public function competition(){
        return $this->belongsTo(Competition::class,"competition_id");
    }
}

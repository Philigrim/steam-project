<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SteamCenterHasRoom extends Model
{
    protected $fillable = [
    'steam_id', 'room_id'  
    ];

    public function steam_center(){
        return $this->belongsTo(SteamCenter::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

}

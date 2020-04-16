<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SteamCenter extends Model
{
    protected $fillable = [
        'name','city_id','room_id'
    ];

    public function city(){
        return $this->belongsTo(City::class);
    }
    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function find_room(){
        return $this->belongsTo(SteamCenterHasRoom::class);
    }
}

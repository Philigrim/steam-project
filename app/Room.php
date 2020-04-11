<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number', 'capacity','course_category'
    ];


    public function steam_center_has_room(){
        return $this->hasOne(SteamCenterHasRoom::class);
    }

    public function room_has_inventory(){
        return $this->hasMany(RoomHasInventory::class);
    }
    public function event(){
        return $this->hasMany(Event::class);
    }

}

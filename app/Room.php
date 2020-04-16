<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number','steam_center_id', 'capacity','course_category'
    ];



    public function steam_center(){
        return $this->belongsTo(SteamCenter::class);
    }
    public function find_steam(){
        return $this->belongsTo(SteamCenterHasRoom::class, 'id', 'room_id');
    }

    public function room_has_inventory(){
        return $this->belongsTo(RoomHasInventory::class);
    }
    public function event(){
        return $this->belongsTo(Event::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number', 'capacity','course_category'
    ];

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

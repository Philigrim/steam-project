<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number','steam_center_id', 'capacity','course_category'
    ];

    public function steam(){
        return $this->belongsTo(SteamCenter::class, 'steam_center_id', 'id');
    }

    public function room_has_inventory(){
        return $this->belongsTo(RoomHasInventory::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

}

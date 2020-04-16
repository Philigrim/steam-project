<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'room_id','start_time','end_time','date','event_id'
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}

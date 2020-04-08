<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'room_id','course_id','steam_id','lecturer_id','capacity_left','description'
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }
<<<<<<< HEAD
    public function steam_center(){
        return $this->belongsTo(SteamCenter::class);
    }
   

=======
>>>>>>> 92f36c02cdce64fa1030a72ec3159dc4e83a98b8
}

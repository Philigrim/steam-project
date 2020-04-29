<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'room_id','course_id','lecturer_id','capacity_left','description','max_capacity', 'isPromoted'
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function lecturer(){
        return $this->belongsTo(LecturerHasEvent::class, 'id', 'event_id', '');
    }
    public function teacher(){
        return $this->belongsTo(EventHasTeacher::class, 'id', 'event_id', '');
    }
    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
    public function file(){
        return $this->belongsTo(File::class);
    }
}

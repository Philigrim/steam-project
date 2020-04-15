<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventHasTeacher extends Model
{
    protected $fillable = [
        'event_id', 'teacher_id','pupil_count'
    ];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    protected $primaryKey = ['event_id', 'teacher_id'];
    public $incrementing = false;
}

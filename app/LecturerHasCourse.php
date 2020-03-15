<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LecturerHasCourse extends Model
{
    protected $fillable = [
        'course_id', 'lecturer_id'
    ];

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    protected $table = 'lecturer_has_courses';
}

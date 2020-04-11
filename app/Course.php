<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_title', 'subject', 'description', 'comments'
    ];

    public function lecturer_has_course(){
        return $this->hasMany(LecturerHasCourse::class);
    }
    public function event(){
        return $this->hasMany(Event::class);
    }
}

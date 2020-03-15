<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_title', 'subject', 'description', 'comments'
    ];

    public function lecturer_has_course(){
        return $this->hasOne(LecturerHasCourse::class);
    }
}

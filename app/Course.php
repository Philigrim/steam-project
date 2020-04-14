<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_title', 'subject', 'description', 'comments'
    ];

    public function find_lecturer(){
        return $this->belongsTo(LecturerHasCourse::class);
    }
}

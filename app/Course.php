<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_title', 'subject_id', 'description', 'comments'
    ];

    public function find_lecturer(){
        return $this->belongsTo(LecturerHasCourse::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function find_course(){
        return $this->belongsTo(LecturerHasCourse::class);
    }

    public function find_subject(){
        return $this->belongsTo(LecturerHasSubject::class);
    }
}

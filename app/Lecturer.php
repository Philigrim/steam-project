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

    public function lecturer_has_course(){
        return $this->hasMany(LecturerHasCourse::class);
    }
    public function event(){
        return $this->hasMany(Event::class);
    }
}

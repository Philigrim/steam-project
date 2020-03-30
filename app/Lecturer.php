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
<<<<<<< HEAD
        return $this->hasOne(LecturerHasCourse::class);
=======
        return $this->hasMany(LecturerHasCourse::class);
    }
    public function event(){
        return $this->hasMany(Event::class);
>>>>>>> bbda21defa364711d983b6b872fa1f9d845d6389
    }
}

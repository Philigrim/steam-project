<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LecturerHasSubject extends Model
{
    protected $fillable = [
        'lecturer_id', 'subject_id'
    ];

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    protected $primaryKey = ['lecturer_id', 'subject_id'];
    public $incrementing = false;
}

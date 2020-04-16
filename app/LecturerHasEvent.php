<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class LecturerHasEvent extends Model
{
    protected $fillable = [
        'lecturer_id','event_id'
    ];

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    protected $primaryKey = ['lecturer_id', 'event_id'];
    public $incrementing = false;
}

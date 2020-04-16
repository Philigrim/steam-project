<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function find_lecturer(){
        return $this->belongsTo(LecturerHasSubject::class);
    }
}

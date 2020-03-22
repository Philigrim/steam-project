<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SteamCenter extends Model
{
    protected $fillable = [
        'name','city_id'
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

 
}

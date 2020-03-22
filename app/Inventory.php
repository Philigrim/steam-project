<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'name','quantity'
    ];

    public function room_has_inventory(){
        return $this->hasMany(RoomHasInventory::class);
    }
   
}

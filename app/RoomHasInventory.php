<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomHasInventory extends Model
{      
    protected $fillable = [
        'steam_id', 'inventory_id'  
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomHasInventory extends Model
{      
    protected $fillable = [
        'steam_id', 'inventory_id'  
    ];

    public function steam_center(){
        return $this->belongsTo(SteamCenter::class);
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use App\SteamCenter;
use App\SteamCenterHasRoom;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        $events = Event::all();
//        $steam_center = SteamCenterHasRoom::where('room_id', '=', $events->room_id)->select('steam_id')->get();
//        $address = SteamCenter::where('id', '=', $steam_center[0]->steam_id)->select('address')->get();
//        , ['address'=>$address]
        return view('paskaitos', ['events'=>$events]);
    }
}

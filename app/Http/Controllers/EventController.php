<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventHasTeacher;
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
        $count = $events->count()/2;

        if($count == 0){
            $count = 2;
        }

        return view('paskaitos', ['events'=>$events], ['count'=>$count]);
    }
    
    public function insert(Request $request){


        EventHasTeacher::create([
            'teacher_id' => $request->name,
            'event_id' => $request->event_id,
            'pupil_count' => $request->pupil_count]);

        return redirect()->back()->with('message', 'Tu saunuolis');
    }

}

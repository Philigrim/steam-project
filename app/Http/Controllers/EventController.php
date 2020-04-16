<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use App\Lecturer;
use App\LecturerHasEvent;
use App\Reservation;
use App\SteamCenter;
use App\SteamCenterHasRoom;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        $reservations = Reservation::all();
        $lecturers = LecturerHasEvent::all()->groupBy('event_id')->collect();
        $events = Event::all();
        $count = $reservations->count()/2;

        if($count == 0.5){
            $count = 2;
        }

        return view('paskaitos', ['events'=>$events, 'count'=>$count, 'lecturers'=>$lecturers, 'reservations'=>$reservations]);
    }
}

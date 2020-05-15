<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
use App\Lecturer;
use App\LecturerHasEvent;
use App\Event;
use App\Reservation;
use App\Teacher;
use App\EventHasTeacher;

class CalendarController extends Controller
{
    public function index()
    {
        
    if(\Auth::user()->isRole()=="paskaitu_lektorius"){
        $lecturer_id=Lecturer::all()->where('user_id','=',\Auth::user()->id)->first()->id;
        $event_ids=LecturerHasEvent::all()->where('lecturer_id',$lecturer_id)->pluck('event_id');
    }
    elseif(\Auth::user()->isRole()=="mokytojas") {
        $teacher_id=Teacher::all()->where('user_id','=',\Auth::user()->id)->first()->id;
        $event_ids=EventHasTeacher::all()->where('teacher_id',$teacher_id)->pluck('event_id');
    }

    $events = Event::all()->whereIn('id',$event_ids)->collect();
    $reservations = Reservation::all()->whereIn('event_id',$event_ids);
        return view('calendar', compact('reservations'));
    }

}

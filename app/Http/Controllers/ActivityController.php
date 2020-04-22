<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Teacher;
use App\User;
use App\Event;
use App\EventHasTeacher;
use App\Reservation;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teacher_id=Teacher::all()->where('user_id','=',\Auth::user()->id)->first()->id;
        $event_ids=EventHasTeacher::all()->where('teacher_id',$teacher_id)->pluck('event_id');
        $events = Event::all()->whereIn('id',$event_ids)->collect();
        $reservations = Reservation::all()->whereIn('event_id',$event_ids);
        
        date_default_timezone_set('Europe/Vilnius');
        $date = date('Y-m-d', time());
        $time = date('H:i:s', time());

        $futureEvents1 = $reservations->where('date', '>', $date);
        $futureEvents2 = $reservations->where('date', $date)->where('end_time', '>', $time);
        $futureEvents = $futureEvents1->merge($futureEvents2)->sortBy('end_time')->sortBy('date');

        $pastEvents1 = $reservations->where('date', '<', $date);
        $pastEvents2 = $reservations->where('date', $date)->where('end_time', '<', $time);
        $pastEvents = $pastEvents1->merge($pastEvents2)->sortBy('end_time')->sortBy('date');

        return view('manopaskaitos',['events'=>$events, 'futureEvents'=>$futureEvents, 'pastEvents'=>$pastEvents]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        $events = Event::all();

        return view('paskaitos', ['events'=>$events]);
    }
}

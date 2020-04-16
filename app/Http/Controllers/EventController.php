<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use App\Event;
use App\Teacher;
use App\EventHasTeacher;
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

    public function fetch_lecturers(Request $request){
        $event_id = $request->get('event_id');

        $lecturers = LecturerHasEvent::all()->where('event_id', '=', $event_id)->collect();

        $output = '';

        foreach($lecturers as $lecturer){
            $output .= '<h3 class="ml-3 mt-3 p-1 btn btn-facebook my-2">
                            '. $lecturer->lecturer->user->firstname .' '. $lecturer->lecturer->user->lastname .'
                        </h3>';
        }

        echo $output;
    }

    public function insert(Request $request){


        if(\Auth::user()->isRole()=== 'mokytojas'){

            $teacher=Teacher::all()->where('user_id','=',\Auth::user()->id)->first()->id;
        }


        $capacity = Event::select('capacity_left')->where(['id'=>$request->event_id])->first();
        $subcapacity = ((int)($capacity ->capacity_left)-(int)($request->pupil_count));
        Event::where('id',$request->event_id)
                                                ->update([
                                                        'capacity_left'=>$subcapacity
                                                    ]);

        EventHasTeacher::create([
            'teacher_id' => $teacher,
            'event_id' => $request->event_id,
            'pupil_count' => $request->pupil_count]);

        return redirect()->back()->with('message', 'Tu saunuolis');
    }

}

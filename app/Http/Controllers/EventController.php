<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use App\Event;
use App\Teacher;
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

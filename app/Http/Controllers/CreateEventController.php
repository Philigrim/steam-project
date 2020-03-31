<?php

namespace App\Http\Controllers;
use App\Course;
use App\Room;
use App\SteamCenter;
use App\City;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class CreateEventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){  
        
        $steams = SteamCenter::all();
        $courses = Course::all();
        $cities = City::all()->pluck("name","id");
        return view('sukurti-paskaita',('cities'),['courses'=>$courses,'steams'=>$steams]);
    }
    public function findSteamCenter ($id)
    {
         $steams= SteamCenter::all()->where("city_id",$id)->pluck("name","id");
         return json_encode($steams);
    }  
    public function findRoom($id)
    {

        
        $rooms = Room::all()->where("steam_id",$id)->pluck("room_number","id");
        return json_encode($rooms); 
        
    }
    public function insert (Request $request){
        $event = Event::create([
        'name' => $request->name,
        'course_id' => $request->course_id,
        'room_id' => $request->room_id,
        'city_id' => $request->city_id,
        'steam_id' => $request->steam_id,
        'description' => $request->description]);
        return redirect()->back()->with('message', 'Kursas pridėtas. Jį galite matyti Kursų puslapyje.');
    }


}

<?php

namespace App\Http\Controllers;
use App\Course;
use App\Room;
use App\SteamCenter;
use App\City;
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
        $courses = Course::all();
        $cities = City::all()->pluck("name","id");
        return view('sukurti-paskaita',compact('cities'));
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


}

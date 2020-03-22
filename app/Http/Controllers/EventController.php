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
class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('paskaitos');
    }

    public function findSteamCenter ($id)
    {
         $steams= SteamCenter::all()->where("city_id",$id)->pluck("name","id");
         return json_encode($steams);
    }
    public function getCities()
    {
        $rooms = Room::all()->pluck("");
        $courses = Course::all();
        $cities = City::all()->pluck("name","id");
        return view('eventu-kurimas',compact('cities','rooms'),['courses'=>$courses]);
    }


}

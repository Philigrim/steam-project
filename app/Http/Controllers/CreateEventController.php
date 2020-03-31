<?php

namespace App\Http\Controllers;
use App\LecturerHasCourse;
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
        $rooms = Room::all()->pluck("");
        $cities = City::all()->pluck("name","id");

        $lecturer_has_courses = LecturerHasCourse::all()->groupBy('lecturer_id');
        $lecturer_has_courses->toArray();
        return view('eventu-kurimas', ['lecturer_has_courses'=>$lecturer_has_courses], compact('cities', 'rooms'));
    }

    function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = LecturerHasCourse::all()->where($select, $value);

        $output = '<option value="" selected disabled>Pasirinkti kursą</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->course_id.'">'.$row->course->course_title.'</option>';
        }
        echo $output;
    }

    public function findSteamCenter ($id)
    {
         $steams= SteamCenter::all()->where("city_id",$id)->pluck("name","id");
         return json_encode($steams);
    }

    public function getCities()
    {
        $rooms = Room::all()->pluck("");
        $cities = City::all()->pluck("name","id");

        return view('eventu-kurimas',compact('cities','rooms'));
    }


}

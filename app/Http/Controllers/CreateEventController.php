<?php

namespace App\Http\Controllers;
use App\LecturerHasCourse;
use App\Room;
use App\SteamCenter;
use App\City;
use App\SteamCenterHasRoom;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Event;

class CreateEventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
//        $rooms = Room::all()->pluck("");
//        $cities = City::all()->pluck("name","id");

        //select * from city inner join steam on city.id = steam.city_id inner join room on steam_id=room.steam_id

        $city_steam_room = SteamCenter::with('city', 'room')->get();


        $grouped = $city_steam_room->groupBy('city_id');

        $lecturer_has_courses = LecturerHasCourse::all()->groupBy('lecturer_id');
        return view('eventu-kurimas', ['lecturer_has_courses'=>$lecturer_has_courses], ['city_steam_room'=>$grouped]);
    }

    function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        if($dependent == 'course_id') {
            $data = LecturerHasCourse::all()->where($select, $value);
            $output = '<option value="" selected disabled>Kursas</option>';
            foreach ($data as $row) {
                $output .= '<option value="' . $row->course_id . '">' . $row->course->course_title . '</option>';
            }
            echo $output;
        }else{
            $city_steam_room = SteamCenter::with('city', 'room')->get();

            $data = $city_steam_room->where($select, $value);

            if($dependent == 'steam_id'){
                $city_steam_room = SteamCenter::with('city', 'room')->get();

                $data = $city_steam_room->where($select, $value);

                $output = '<option value="" selected disabled>STEAM Centras</option>';
                foreach ($data as $row) {
                    $output .= '<option value="' . $row->id . '">' . $row->steam_name . '</option>';
                }
                echo $output;
            }else if($dependent == 'room_id'){
                $city_steam_room = SteamCenter::with('room')->get();

                $data = $city_steam_room->where('id', $value);

                $output = '<option value="" selected disabled>Kambarys</option>';
                foreach ($data as $row) {
                    foreach($row->room as $single_room){
                        $output .= '<option value="' . $single_room->id . '">' . $single_room->room_number . '</option>';
                    }
                }
                echo $output;
            }
        }
    }

    public function insert(Request $request){
        Event::create(['name' => $request->name,
            'room_id' => $request->room_id,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'comments' => $request->comments,
            'capacity_left' => $request->capacity_left]);

        return redirect()->back()->with('message', 'Paskaita pridėta. Ją galite matyti paskaitų puslapyje.');
    }
}

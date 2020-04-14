<?php

namespace App\Http\Controllers;
use App\Course;
use App\LecturerHasCourse;
use App\LecturerHasSubject;
use App\Room;
use App\Lecturer;
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
        $city_steam_room = SteamCenter::with('city', 'room')->get();

        $grouped = $city_steam_room->groupBy('city_id');

        $courses = Course::all();
        $lecturers = Lecturer::all();

        return view('sukurti-paskaita', ['courses'=>$courses, 'lecturers'=>$lecturers, 'city_steam_room'=>$grouped]);
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

    public function fetch_lecturers(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        if($select === 'subject_id'){
            $output = $this->lecturer_table(LecturerHasSubject::all()->where($select, $value));
        }else if($select === 'course_id'){
            $output = $this->lecturer_table(LecturerHasCourse::all()->where($select, $value));
        }else{
            $output = '';
        }

        echo $output;
    }

    private function lecturer_table($data){
        $output = '<thead></thead>';

        $table_data = '';

        foreach ($data as $row) {
            $table_data .= '<tr data-role="row" data-position="1" class="">
                                <td>
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        <input class="custom-control-input" name="lecturers[]" id="'. $row->lecturer->id .'" value="'. $row->lecturer->id .'" type="checkbox">
                                        <label class="custom-control-label" for="'. $row->lecturer->id .'">
                                            <span class="text-muted">'. $row->lecturer->user->firstname . ' ' . $row->lecturer->user->lastname .'</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>';
        }
        $output = '<tbody>'. $table_data .'</tbody>';
        return $output;
    }

    public function insert(Request $request){

        $room = Room::where('id', '=', $request->room_id)->select('capacity')->get();

        Event::create(['name' => $request->name,
            'room_id' => $request->room_id,
            'course_id' => $request->course_id,
            'lecturer_id' => $request->lecturer_id,
            'description' => $request->description,
            'comments' => $request->comments,
            'capacity_left' => $room[0]->capacity]);

        return redirect()->back()->with('message', 'Paskaita pridėta. Ją galite matyti paskaitų puslapyje.');
    }
}

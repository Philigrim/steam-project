<?php

namespace App\Http\Controllers;
use App\Course;
use App\LecturerHasCourse;
use App\LecturerHasEvent;
use App\LecturerHasSubject;
use App\Reservation;
use App\Room;
use App\Lecturer;
use App\SteamCenter;
use App\City;
use App\SteamCenterHasRoom;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use DateTime;
use App\Event;
use App\File;

class CreateEventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $cities = City::all();
//        $steam_centers = SteamCenter::all();
//        $rooms = Room::all();
        // 'steam_centers'=>$steam_centers, 'rooms'=>$rooms]

        $courses = Course::all();
        $lecturers = Lecturer::all();

        return view('sukurti-paskaita', ['courses'=>$courses, 'lecturers'=>$lecturers, 'cities'=>$cities]);
    }

    function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        if($dependent == 'steam_id'){
            $steam_centers = SteamCenter::all()->where($select, '=', $value);

            $output = '<option value="" selected disabled>STEAM Centras</option>';
            foreach ($steam_centers as $steam_center) {
                $output .= '<option value="' . $steam_center->id . '">' . $steam_center->steam_name . '</option>';
            }
            echo $output;
        }else if($dependent == 'room_id'){
            $rooms = Room::all()->where('steam_center_id','=', $value);

            $output = '<option value="" selected disabled>Kambarys</option>';
            foreach ($rooms as $room) {
                $output .= '<option data-capacity="'. $room->capacity .'" value="' . $room->id . '">' . $room->room_number .'('. $room->capacity .')'.' '. $room->subject->subject .'</option>';
            }
            echo $output;
        }
    }

    public function fetch_lecturers(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');

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

    public function fetch_time(Request $request){
        $date_value = $request->get('date_value');
        $room_value = $request->get('room_value');

        $start_times = array();
        $start_times['08:30:00'] = '10:00:00';
        $start_times['10:15:00'] = '11:45:00';
        $start_times['12:00:00'] = '13:30:00';
        $start_times['14:00:00'] = '15:30:00';

        $reservations = Reservation::all()->where('date', '=', $date_value)->where('room_id', '=', $room_value);

        if($reservations != null){
            foreach($reservations as $res){
                unset($start_times[$res->start_time]);
            }
        }

        $output = '<option value="" selected disabled>Laikas</option>';
        foreach($start_times as $start_time => $end_time){
            $output .= '<option value="'. $start_time .'-'. $end_time .'">'. substr($start_time, 0, 5) .'-'. substr($end_time, 0, 5) .'</option>';
        }

        echo $output;
    }

    public function insert(Request $request){

        $request->validate([
            'name' => 'required',
            'lecturers' => 'required',
            'course_id' => 'required',
            'city_id' => 'required',
            'steam_id' => 'required',
            'room_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'capacity' => 'required',
            'description' => 'required',
            'file' => 'mimes:doc,docx,pdf,txt,pptx,ppsx,odt,ods,odp,tiff,jpeg,png|max:5120'
        ],[
            'name.required' => ' Paskaitos pavadinimas yra privalomas!',
            'lecturers.required' => ' Pasirinkite bent vieną dėstytoją!',
            'course_id.required' => ' Nepasirinkote kurso!',
            'city_id.required' => ' Nepasirinkote miesto!',
            'steam_id.required' => ' Nepasirinkote STEAM centro!',
            'room_id.required' => ' Nepasirinkote kambario!',
            'date.required' => ' Nepasirinkote datos!',
            'time.required' => ' Nepasirinkote laiko!',
            'capacity.required' => ' Nepasirinkto žmonių skaičiaus!',
            'description.required' => ' Paskaitos aprašymas yra privalomas!',
            'file.mimes' => ' Blogas pasirinktas failo formatas',
            'file.max' => ' Per didelis failas'
        ]);
        
        
        if($request->hasFile('file')){
                            $filename = $request ->file -> getClientOriginalName();
                            $request->file -> storeAs(('public/file'),$filename);
                            $file = File ::create(
                                ['name' =>$filename]
                            );

                        }
        $event = Event::create(['name' => $request->name,
            'room_id' => $request->room_id,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'capacity_left' => $request->capacity,
            'max_capacity' => $request->capacity,
            'isPromoted' => 'f',
            'file_id' => $file->id]);

        foreach($request->lecturers as $lecturer){
            LecturerHasEvent::create(['lecturer_id' => $lecturer,
                'event_id'=>$event->id]);
        }

        
        $arr = explode("-", $request->time, 2);
        $start_time = $arr[0];
        $end_time = $arr[1];

        $date = $request->date;

    
        Reservation::create(['room_id' => $request->room_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'date' => $date,
            'event_id' => $event->id]);

        
        return redirect()->back()->with('message', 'Paskaita pridėta. Ją galite matyti paskaitų puslapyje.');
    }
}

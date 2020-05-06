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
use App\Subject;
use App\City;
use App\SteamCenterHasRoom;
use Illuminate\Http\Request;
use App\File;
class EventController extends Controller
{
    public function index(){
        $reservations = Reservation::paginate(15);
        $lecturers = LecturerHasEvent::all()->groupBy('event_id')->collect();
        $events = Event::all();
        $count = $reservations->count()/2;

        if($count == 0.5){
            $count = 2;
        }
        
        $subjects = Subject::all();
        $cities = City::all();

        return view('paskaitos', ['events'=>$events, 'count'=>$count, 'lecturers'=>$lecturers, 'reservations'=>$reservations, 'subjects'=>$subjects, 'cities'=>$cities]);
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
    public function download ($id){
        $dl = File::find($id);
        return  response()->download(storage_path('app/public/file/'.$dl->name));
    }
    public function filter(Request $request)
    {
        $filtered = 'f';
        $capacity = $request->get('filterCapacityInput');
        $category = $request->get('filterCategoryInput');
        $city = $request->get('filterCityInput');

        $events = Event::join('rooms', 'rooms.id', '=', 'events.room_id')
                       ->join('steam_centers', 'steam_centers.id', '=', 'rooms.steam_center_id')
                       ->join('cities', 'cities.id', '=', 'steam_centers.city_id')
                       ->join('courses', 'courses.id', '=', 'events.course_id')
                       ->join('subjects', 'subjects.id', '=', 'courses.subject_id');
                       
  

        if(isset($category)){
            $events = $events->where('subjects.subject', '=', $category);
            $filtered = 't';
        }

        if(isset($capacity)){          
            $events = $events->where('capacity_left', '>=', $capacity);
            $filtered = 't';
        }
        
        if(isset($city)){
            $events = $events->where('city_name', '=', $city);
            $filtered = 't';
        }

        $date_value = $request->get('filterDateInput');
        $dateOneDay = $request->get('filterDateOneDay');
        $dateFrom = $request->get('filterDateFrom');
        $dateTill = $request->get('filterDateTill');

        if(isset($date_value)){
        if($dateOneDay != "" && $date_value=="oneDay"){
            $reservations = $reservations->where('date', $dateOneDay)->paginate(15);
            $filtered = 't';
        } else if ($dateFrom != "" && $date_value=="from"){
            $reservations1 = $reservations->where('date', '>', $dateFrom);
            $reservations2 = $reservations->where('date', $dateFrom);
            $reservations=$reservations1->merge($reservations2);
            $filtered = 't';
        } else if ($dateTill != "" && $date_value=="till"){
            $reservations1 = $reservations->where('date', '<', $dateTill);
            $reservations2 = $reservations->where('date', $dateTill);
            $reservations=$reservations1->merge($reservations2);
            $filtered = 't';
        } else if ($dateFrom != "" && $dateTill != "" && $date_value=="interval" && $dateFrom<$dateTill){
            $reservations = $reservations->whereBetween('date', [$dateFrom, $dateTill]);
            $filtered = 't';
        } else {
            $date_value = "";
        }
        }

        $reservations = Reservation::whereIn('event_id', $events->pluck('events.id'))->paginate(15);
        
        $count = $reservations->count()/2;
        if($count == 0.5){
            $count = 2;
        }

        $lecturers = LecturerHasEvent::all()->whereIn('event_id', $events->pluck('events.id'))->groupBy('event_id')->collect();
        $events = $events->get();
        $subjects = Subject::all();
        $cities = City::all();
        
        return view('paskaitos', ['events'=>$events, 'count'=>$count, 'lecturers'=>$lecturers, 'reservations'=>$reservations, 'subjects'=>$subjects, 'cities'=>$cities, 'filtered'=>$filtered,
            'category_value'=>$category, 'city_value'=>$city, 'capacity_value'=>$capacity,
            'date_value'=>$date_value, 'dateOneDay'=>$dateOneDay, 'dateFrom'=>$dateFrom, 'dateTill'=>$dateTill ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $events = Event::where('name', 'like', '%'.$query.'%')
                       ->orWhere('description', 'like', '%'.$query.'%');

        $reservations = Reservation::whereIn('event_id', $events->pluck('events.id'))->paginate(15);
        
        $count = $reservations->count()/2;
        if($count == 0.5){
            $count = 2;
        }

        $lecturers = LecturerHasEvent::all()->whereIn('event_id', $events->pluck('events.id'))->groupBy('event_id')->collect();
        $events = $events->get();
        $subjects = Subject::all();
        $cities = City::all();

        return view('paskaitos', ['events'=>$events, 'count'=>$count, 'lecturers'=>$lecturers, 'reservations'=>$reservations, 'subjects'=>$subjects, 'cities'=>$cities]);
    }

    public function insert(Request $request){

    
        $teacher=Teacher::all()->where('user_id','=',\Auth::user()->id)->first()->id;
        $capacity = Event::select('capacity_left')->where(['id'=>$request->event_id])->first();
        
        try{
           EventHasTeacher::create([
            'teacher_id' => $teacher,
            'event_id' => $request->event_id,
            'pupil_count' => $request->pupil_count]);
        $subcapacity = ((int)($capacity ->capacity_left)-(int)($request->pupil_count));
        Event::where('id',$request->event_id)
                                                ->update([
                                                        'capacity_left'=>$subcapacity
                                                    ]);
         }catch(\Illuminate\Database\QueryException $e){
                return \redirect()->back()->with('message','Jūs jau užsiregistravę į šią paskaitą!');         
        }
        

        return redirect()->back()->with('message', 'Jūs sėkmingai užsiregistravote į paskaitą');
    }

    // public function promote(Request $request)
    // {
    //     $event = Event::find($request->event_id);
    //     $event->isPromoted = $request->isPromoted;
    //     $event->save();
    // }
}

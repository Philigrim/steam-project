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
        $reservations = Reservation::all();
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
        $capacity = $request->get('filterCapacityInput');
        $category = $request->get('filterCategoryInput');
        $city = $request->get('filterCityInput');
        $dateFrom = $request->get('filterDateFrom');

        $events = Event::join('rooms', 'rooms.id', '=', 'events.room_id')
                       ->join('steam_centers', 'steam_centers.id', '=', 'rooms.steam_center_id')
                       ->join('cities', 'cities.id', '=', 'steam_centers.city_id')
                       ->join('courses', 'courses.id', '=', 'events.course_id')
                       ->join('subjects', 'subjects.id', '=', 'courses.subject_id');
                       
        $reservations = Reservation::all();

        if(isset($category)){
            $events = $events->where('subjects.subject', '=', $category);
        }

        if(isset($capacity)){          
            $events = $events->where('capacity_left', '>=', $capacity);
        }
        
        if(isset($city)){
            $events = $events->where('city_name', '=', $city);
        }

        if(isset($dateFrom)){
            $dateTo = $request->get('filterDateTo');
            if(isset($dateTo)){
                $reservations = $reservations->whereBetween('date', [$dateFrom, $dateTo]);
            } else {
                $reservations = $reservations->where('date', '=', $dateFrom);
            }
        }

        $reservations = $reservations->whereIn('event_id', $events->pluck('events.id'));
        
        $count = $reservations->count()/2;
        if($count == 0.5){
            $count = 2;
        }

        $lecturers = LecturerHasEvent::all()->whereIn('event_id', $events->pluck('events.id'))->groupBy('event_id')->collect();
        $events = $events->get();
        $subjects = Subject::all();
        $cities = City::all();

        $filtered = 't';
        
        return view('paskaitos', ['events'=>$events, 'count'=>$count, 'lecturers'=>$lecturers, 'reservations'=>$reservations, 'subjects'=>$subjects, 'cities'=>$cities, 'filtered'=>$filtered]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $events = Event::where('name', 'like', '%'.$query.'%')
                       ->orWhere('description', 'like', '%'.$query.'%');

        $reservations = Reservation::all()->whereIn('event_id', $events->pluck('events.id'));
        
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

    public function promote(Request $request)
    {
        $event = Event::find($request->event_id);
        $event->isPromoted = $request->isPromoted;
        $event->save();
    }
}

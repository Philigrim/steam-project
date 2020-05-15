<?php

namespace App\Http\Controllers;

use App\City;
use App\Event;
use App\Lecturer;
use App\LecturerHasCourse;
use App\LecturerHasEvent;
use App\Reservation;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Course;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function GetCourses(){
        $courses = Course::all();

        if(\Auth::user()->isRole() === 'paskaitu_lektorius'){
            $lecturer_id = Lecturer::all()->where('user_id', '=', \Auth::user()->id)->first()->id;

            $course_ids = LecturerHasCourse::all()->where('lecturer_id', $lecturer_id)->pluck('course_id');
            $courses = $courses->whereIn('id', $course_ids)->collect();
        }

        return $courses;
    }

    public function index()
    {
        if(\Auth::user()->isRole() === 'admin' || \Auth::user()->isRole() === 'paskaitu_lektorius'){
            $courses = $this->GetCourses();
            return view('kursai',['courses'=>$courses]);
        }else{
            return view('/about');
        }
    }

    public function index_reservations(Request $request){
        date_default_timezone_set('Europe/Vilnius');
        $today_date = date('Y-m-d', time());
        $time_now = date('H:i:s', time());

        $course_id = $request->course_id;

        $event_ids = Event::all()->where('course_id', '=', $course_id)->pluck('id');

        //$reservations = Reservation::all()->whereIn('event_id', $event_ids);
        $reservations = Reservation::all();

        $futureReservations1 = $reservations->where('date', '>', $today_date);
        $todayFutureReservations2 = $reservations->where('date', $today_date)->where('start_time', '>', $time_now);
        $reservations = $futureReservations1->merge($todayFutureReservations2);

        $lecturers = LecturerHasEvent::all()->groupBy('event_id')->collect();
        $events = Event::all();

        $subjects = Subject::all();
        $cities = City::all();

        $lecturersForEdit = Lecturer::all();
        $courses = Course::all();

        return view('paskaitos', ['events'=>$events, 'lecturers'=>$lecturers, 'reservations'=>$reservations, 'subjects'=>$subjects, 'cities'=>$cities, 'courses'=>$courses, 'lecturersForedit'=>$lecturersForEdit]);
    }
}

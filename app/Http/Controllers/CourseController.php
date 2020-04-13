<?php

namespace App\Http\Controllers;

use App\Lecturer;
use App\LecturerHasCourse;
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

    public function index()
    {
        if(\Auth::user()->isRole() === 'admin'){
            $courses = Course::all();
            $count = $courses->count()/2;
        }else if(\Auth::user()->isRole() === 'paskaitu_lektorius'){
            $lecturer_id = Lecturer::all()->where('user_id', '=', \Auth::user()->id)->first()->id;

            $course_ids = LecturerHasCourse::all()->where('lecturer_id', $lecturer_id)->pluck('id');
            $courses = Course::all()->whereIn('id', $course_ids)->collect();

            $count = sizeof($courses)/2;
        }else{
            return view('home');
        }

        if($count < 1){
            $count = 2;
        }

        return view('kursai',['courses'=>$courses, 'count'=>$count]);
    }
}

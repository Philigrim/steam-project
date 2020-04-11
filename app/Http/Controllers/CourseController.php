<?php

namespace App\Http\Controllers;

use App\LecturerHasCourse;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Course;
use DB;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courses = LecturerHasCourse::all();
        $count = $courses->count()/2;

        if($count == 0){
            $count = 2;
        }

        return view('kursai',['courses'=>$courses], ['count'=>$count]);
    }
}

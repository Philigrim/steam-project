<?php

namespace App\Http\Controllers;

use App\LecturerHasCourse;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Course;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CreateCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $users = User::where('usertype', 'paskaitu_lektorius')->get();

        return view('sukurti-kursa',['users'=>$users]);
    }

    public function insert(Request $request)
    {
        $course = Course::create(['course_title' => $request->course_title,
                        'subject' => $request->subject,
                        'description' => $request->description,
                        'comments' => $request->comments]);

        LecturerHasCourse::create(['course_id' => $course->id,
                                   'lecturer_id' => $request->lecturer_id]);

        return redirect()->back()->with('message', 'Kursas pridėtas. Jį galite matyti Kursų puslapyje.');
    }
}

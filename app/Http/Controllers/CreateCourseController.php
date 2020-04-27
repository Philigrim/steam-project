<?php

namespace App\Http\Controllers;

use App\LecturerHasCourse;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Course;
use App\Subject;
use App\Lecturer;
use App\LecturerHasSubject;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CreateCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $lecturers = Lecturer::all();
        $subjects = Subject::all();

        return view('sukurti-kursa',['lecturers'=>$lecturers], ['subjects'=>$subjects]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'lecturers' => 'required',
            'course_title' =>'required',
            'subject_id'=> 'required',
            'description' => 'required',
            'comments' => 'required'

        ],[
            'lecturers.required' => ' Pasirinkite bent vieną dėstytoją!',
            'course_title.required' => ' Kurso pavadinimas yra privalomas!',
            'subject_id.required' => ' Nepasirinkote dalyko!',
            'description.required' => ' Kurso aprašymas yra privalomas!',
            'comments.required' => ' Kurso papildoma informacija yra privaloma!',   
        ]);

        $subject = Subject::all()->where('id', '=', $request->subject_id)->collect();

        $course = Course::create(['course_title' => $request->course_title,
            'subject_id' => $request->subject_id,
            'description' => $request->description,
            'comments' => $request->comments]);

        $lecturers = $request->lecturers;

        for($x = 0; $x < sizeof($lecturers); $x++){
            LecturerHasCourse::create(['course_id' => $course->id,
                                        'lecturer_id' => $lecturers[$x]]);
        }

        return redirect()->back()->with('message', 'Kursas pridėtas. Jį galite matyti Kursų puslapyje.');
    }
}

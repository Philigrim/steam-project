<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class CreateCourseController extends Controller
{
    public function index(){
        return view('sukurti-kursa');
    }

    public function insert(Request $request)
    {
        $lecturer_name = $request->input('lecturer_name');
        $lecturer_last_name = $request->input('lecturer_last_name');
        $course_title = $request->input('course_title');
        $subject = $request->input('subject');
        $description = $request->input('description');
        $equipment = $request->input('equipment');
        $comments = $request->input('comments');
        $data = array('lecturer_name' => $lecturer_name, "lecturer_last_name" => $lecturer_last_name, "course_title" => $course_title, "subject" => $subject,
                        "description" => $description, "equipment" => $equipment, "comments" => $comments);
        DB::table('courses')->insert($data);
        
        $courses = DB::select('select * from courses');
        return view('mainwindow',['courses'=>$courses]);
    }
}

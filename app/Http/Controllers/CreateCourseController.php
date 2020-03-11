<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CreateCourseController extends Controller
{
    public function index(){

        $users = DB::select('select * from users where usertype =:usertype', ['usertype'=>'paskaitu_lektorius']);
        $courses = DB::select('select * from courses');
        return view('sukurti-kursa',['users'=>$users],['courses'=>$courses]);
    }

    public function insert(Request $request)
    {
        $course_title = $request->input('course_title');
        $subject = $request->input('subject');
        $user_id = $request->input('user_id');
        $description = $request->input('description');
        $comments = $request->input('comments');

        $data = array("course_title" => $course_title, "description" => $description, "subject" => $subject,"user_id"=>$user_id, "comments" => $comments);

        DB::table('courses')->insert($data);
        

        return redirect('sukurti-kursa');
    }
}

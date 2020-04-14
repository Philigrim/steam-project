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

    public function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        $data = LecturerHasSubject::all()->where($select, $value);

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
        echo $output;
    }

    public function insert(Request $request)
    {
        $request->validate([
            'lecturers' => 'required'
        ]);

        $subject = Subject::all('subject')->where('id', '=', $request->subject_id);

        $course = Course::create(['course_title' => $request->course_title,
            'subject' => $subject,
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

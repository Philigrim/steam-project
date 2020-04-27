<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\QuestionAndAnswer;

use App\Event;
use App\LecturerHasEvent;
use App\Reservation;
use App\Subject;
use App\City;

use App\Http\Requests;
use App\Http\Controllers\Controller;
class FAQController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // questions and answers
        $questions_and_answers = QuestionAndAnswer::where('isAnswered', true)->get();
        $questions = QuestionAndAnswer::where("isAnswered", false)->get();
        
        // promoted events
        $events = Event::where("isPromoted", true);
        $reservations = Reservation::whereIn('event_id', $events->pluck('events.id'))->get();
        $lecturers = LecturerHasEvent::all()->whereIn('event_id', $events->pluck('events.id'))->groupBy('event_id');
        $events = $events->get();
        
        return view('faq', ['questions_and_answers'=>$questions_and_answers, 'questions'=>$questions, 'events'=>$events, 'lecturers'=>$lecturers, 'reservations'=>$reservations]);
    }

    public function storeQuestion(Request $request)
    {
        $question = $request->input('question');
        
        $data = array(
        'question' => $question,
        'answer' => 'null',
        'isAnswered' => 'f');

        QuestionAndAnswer::insert($data);

        return redirect()->route('faq')->withStatus(__('Klausimas sėkmingai pateiktas.'));
    }

    public function storeAnswer(Request $request)
    {
        $question = $request->input('question');
        $answer = $request->input('answer');

        $data = array(
        'answer' => $answer,
        'isAnswered' => 't');

        QuestionAndAnswer::where('question', $question)->update($data);

        return redirect()->route('faq')->withStatus(__('Atsakymas sėkmingai pateiktas.'));
    }

    public function update(Request $request)
    {
        $id = $request->input('edited_id');
        $question = $request->input('edited_question');
        $answer = $request->input('edited_answer');

        $data = array(
            'id' => "$id",
            'question' => $question,
            'answer' => $answer);

        QuestionAndAnswer::where('id', $id)->update($data);
        return redirect()->route('faq')->withStatus(__('Klausimas ir atsakymas sėkmingai redaguoti.'));
    }

    public function destroyById($id)
    {
        QuestionAndAnswer::where('id', $id)->delete();
        return redirect()->route('faq')->withStatus(__('Klausimas ir atsakymas sėkmingai ištrinti.'));
    }

    public function destroyByQ($question)
    {
        /** TODO */
        QuestionAndAnswer::where('question', $question)->delete();
        return redirect()->route('faq')->withStatus(__('Klausimas ir atsakymas sėkmingai ištrinti.'));
    }
    
   
}
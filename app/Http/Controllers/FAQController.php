<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\QuestionAndAnswer;
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
        $questions_and_answers = QuestionAndAnswer::where('isAnswered', true)->get();
        $questions = QuestionAndAnswer::where("isAnswered", false)->get();
        return view('faq',['questions_and_answers'=>$questions_and_answers, 'questions'=>$questions]);
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
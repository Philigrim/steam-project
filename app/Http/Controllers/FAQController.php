<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
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
        $questions_and_answers = DB::select('select * from questions_and_answers where "isAnswered"=\'t\'');
        $questions = DB::select('select faq_id, question from questions_and_answers where "isAnswered"=\'f\'');
        return view('faq',['questions_and_answers'=>$questions_and_answers, 'questions'=>$questions]);
    }

    public function storeQuestion(Request $request)
    {
        $question = $request->input('question');
        
        $data = array(
        'question' => $question,
        'answer' => 'null',
        'isAnswered' => 'f');

        DB::table('questions_and_answers')->insert($data);

        return redirect()->route('faq')->withStatus(__('Klausimas sėkmingai pateiktas.'));
    }

    public function storeAnswer(Request $request)
    {
        $question = $request->input('question');
        $answer = $request->input('answer');

        $data = array(
        'answer' => $answer,
        'isAnswered' => 't');

        DB::table('questions_and_answers')->where('question', $question)->update($data);

        return redirect()->route('faq')->withStatus(__('Atsakymas sėkmingai pateiktas.'));
    }

    public function edit($announcement_id)
    {
        $announcement = DB::select('select * from announcements where announcement_id=' . $announcement_id);
        return view('announcements.edit',['announcement'=>$announcement]);
    }

    public function update(Request $request)
    {
        $announcement_id = $request->input('announcement_id');
        $announcement_title = $request->input('announcement_title');
        $announcement_author = $request->input('announcement_author');
        $announcement_text = $request->input('announcement_text');
  
        $data = array(
            'announcement_author' => "$announcement_author",
            'announcement_title' => $announcement_title,
            'announcement_text' => $announcement_text,
            'updated_at' => $modification_date);

        DB::table('announcements')->where('announcement_id', $announcement_id)->update($data);
        return redirect()->route('home')->withStatus(__('Klausimas/Atsakymas sėkmingai redaguotas.'));
    }

    public function destroyById($faq_id)
    {
        DB::table('questions_and_answers')->where('faq_id', $faq_id)->delete();

        return redirect()->route('faq')->withStatus(__('Klausimas ir atsakymas sėkmingai ištrinti.'));
    }

    public function destroyByQ($question)
    {
        DB::table('questions_and_answers')->where('question', $question)->delete();

        return redirect()->route('faq')->withStatus(__('Klausimas ir atsakymas sėkmingai ištrinti.'));
        
        #$checked = Request::input('checked',[]);
        #Todo::whereIn("id",$checked)->delete(); 
    }
    
   
}
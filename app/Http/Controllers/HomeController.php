<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class HomeController extends Controller
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
        $announcements = DB::select('select * from announcements order by announcement_id desc');
        return view('mainwindow',['announcements'=>$announcements]);
    }

    public function store(Request $request)
    {
        $announcement_author = $request->input('announcement_author');
        $announcement_title = $request->input('announcement_title');
        $announcement_text = $request->input('announcement_text');

        date_default_timezone_set('Europe/Vilnius');
        $announcement_date = date('Y/m/d H:i', time());
        
        $data = array(
        'announcement_author' => $announcement_author,
        'announcement_title' => $announcement_title,
        'announcement_text' => $announcement_text,
        'created_at' => $announcement_date);

        DB::table('announcements')->insert($data);

        return redirect()->route('home')->withStatus(__('Pranesimas sukurtas.'));
    }

    public function returnAnnouncement($announcement_id)
    {
        $an=$announcement_id;
        $announcement = DB::select('select * from announcements where announcement_id=' . $announcement_id);
        $announcements = DB::select('select * from announcements order by announcement_id desc');
        return view('mainwindow', ['announcements'=>$announcements], compact($an));
    }

    public function update($announcement_id)
    {
      
        $announcements = DB::select('select * from announcements order by announcement_id desc');
        $announcement = DB::select('select * from announcements where announcement_id=' . $announcement_id);
        return view('announcements.edit',['announcements'=>$announcements])->with('announcement', $announcement);
        #$announcement_id = $request->input('announcement_id');
        #$announcement_title = $request->input('announcement_author');
        #$announcement_author = $request->input('announcement_title');
        #$announcement_text = $request->input('announcement_text');
  
        #date_default_timezone_set('Europe/Vilnius');
        #$modification_date = date('Y/m/d H:i', time());

        #$data = array(
        #    'announcement_author' => $announcement_author,
        #    'announcement_title' => $announcement_title,
        #    'announcement_text' => $announcement_text,
        #    'updated_at' => $modification_date);
            
        #DB::table('announcements')->where('announcement_id', $announcement_id)->update($data);
    }

    public function destroy($announcement_id)
    {
        DB::table('announcements')->where('announcement_id', $announcement_id)->delete();

        return redirect()->route('home')->withStatus(__('Pranesimas istrintas.'));
    }
   
}


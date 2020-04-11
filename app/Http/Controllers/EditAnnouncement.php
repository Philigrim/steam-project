<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class EditAnnouncement extends Controller
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
    public function index($announcement_id)
    {
        $announcements = DB::select('select * from announcements where announcement_id=' . $announcement_id . ' order by announcement_id desc');
        return view('edit',['announcements'=>$announcements]);
    }
   
}


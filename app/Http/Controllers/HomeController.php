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
        //$announcements = DB::select('select * from announcements order by announcement_id desc');
        //return view('mainwindow',['announcements'=>$announcements]);
        return view('mainwindow');
    }

    function action(Request $request)
    {
    if($request->ajax())
    {
    $output = '';
    $query = $request->get('query');
    if($query != '')
    {
    $data = DB::table('announcements')
        ->where('announcement_title', 'like', '%'.$query.'%')
        ->orWhere('announcement_text', 'like', '%'.$query.'%')
        ->orderBy('announcement_id', 'desc')
        ->get();
        
    }
    else
    {
    $data = DB::table('announcements')
        ->orderBy('announcement_id', 'desc')
        ->get();
    }
    $total_row = $data->count();
    if($total_row > 0)
    {
    foreach($data as $row)
    {
        $output .= '
        <tr>
        <td>'.$row->announcement_title.'</td>
        <td>'.$row->announcement_text.'</td>
        </tr>
        ';
    }
    }
    else
    {
    $output = '
    <tr>
        <td align="center" colspan="2">No Data Found</td>
    </tr>
    ';
    }
    $data = array(
    'table_data'  => $output,
    'total_data'  => $total_row
    );

    echo json_encode($data);
    }
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

        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai sukurtas.'));
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
  
        date_default_timezone_set('Europe/Vilnius');
        $modification_date = date('Y/m/d H:i', time());

        $data = array(
            'announcement_author' => "$announcement_author",
            'announcement_title' => $announcement_title,
            'announcement_text' => $announcement_text,
            'updated_at' => $modification_date);

        DB::table('announcements')->where('announcement_id', $announcement_id)->update($data);
        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai redaguotas.'));
    }

    public function destroy($announcement_id)
    {
        DB::table('announcements')->where('announcement_id', $announcement_id)->delete();

        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai ištrintas.'));
    }
}
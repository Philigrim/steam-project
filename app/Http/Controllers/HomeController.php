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
        ->orderBy('id', 'desc')
        ->get();

    }
    else
    {
    $data = DB::table('announcements')
        ->orderBy('id', 'desc')
        ->get();
    }
    $total_row = $data->count();
    if($total_row > 0)
    {
    foreach($data as $row)
    {
        $output .= '
        <div class="card card-stats mt-3 xl-7">
        <div class="card-body border border-primary rounded">
        @if (Auth::user()->isRole()=="admin"))
        <div class="row d-flex float-right">
        <form action="{{ route(\'announcement.edit\', '.$row->id.') }}" method="get">
        <input class="btn btn-success ml-3" type="submit" value="Redaguoti" />
        </form> 

        <form action="{{ url(\'/announcements\', '.$row->id.') }}" method="post">
        <input class="btn btn-danger ml-3" type="submit" value="Ištrinti" />
        <input type="hidden" name="_method" value="delete" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form> 
        </div>

        <br>
        <br>
        @endif
        <div class="border-top mt-2 mb-2"></div>

        <div class="row d-flex justify-content-center">
        <h1 class="card-title font-weight-bold">'.$row->announcement_title.'</h1>
        </div>

        <div class="border-top mt-2 mb-2"></div>

        <div>
        <span class="ml-2">Autorius:</span>
        <span class="ml-2">'.$row->announcement_author.'</span>
        <div class="ml-2 float-right">'.$row->created_at.'</div>
        </div>

        <div class="border-top mt-2 mb-2"></div>

        <div class="ml-2">'.$row->announcement_text.'</div>

        <div class="border-top mt-2 mb-2"></div>
        </div>
        </div>
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

    public function edit($id)
    {
        $announcement = DB::select('select * from announcements where id=' . $id);
        return view('announcements.edit',['announcement'=>$announcement]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
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

        DB::table('announcements')->where('id', $id)->update($data);
        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai redaguotas.'));
    }

    public function destroy($id)
    {
        DB::table('announcements')->where('id', $id)->delete();

        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai ištrintas.'));
    }
}

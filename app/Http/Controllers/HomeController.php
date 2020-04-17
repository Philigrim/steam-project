<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Announcement;
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
    $data = Announcement::where('title', 'like', '%'.$query.'%')
                         ->orWhere('text', 'like', '%'.$query.'%')
                         ->orderBy('id', 'desc')
                         ->get();

    }
    else
    {
    $data = Announcement::orderBy('id', 'desc')->get();
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
        <h1 class="card-title font-weight-bold">'.$row->title.'</h1>
        </div>

        <div class="border-top mt-2 mb-2"></div>

        <div>
        <span class="ml-2">Autorius:</span>
        <span class="ml-2">'.$row->author.'</span>
        <div class="ml-2 float-right">'.$row->created_at.'</div>
        </div>

        <div class="border-top mt-2 mb-2"></div>

        <div class="ml-2">'.$row->text.'</div>

        <div class="border-top mt-2 mb-2"></div>
        </div>
        </div>
        ';
    }
    }
    else
    {
    $output = '
    <br>
    <h3 align="center">Pranesimų pagal pateiktą užklausą nerasta.</h3>
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
        $author_id = \Auth::user()->id;
        $author = $request->input('announcement_author');
        $title = $request->input('announcement_title');
        $text = $request->input('announcement_text');

        date_default_timezone_set('Europe/Vilnius');
        $announcement_date = date('Y/m/d H:i', time());

        $data = array(
        'author_id' => $author_id,
        'author' => $author,
        'title' => $title,
        'text' => $text,
        'created_at' => $announcement_date);

        Announcement::insert($data);

        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai sukurtas.'));
    }

    public function edit($id)
    {
        $announcement = Announcement::select('select * from announcements where id=' . $id);
        return view('announcements.edit',['announcement'=>$announcement]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $author = $request->input('author');
        $text = $request->input('text');

        date_default_timezone_set('Europe/Vilnius');
        $modification_date = date('Y/m/d H:i', time());

        $data = array(
            'author' => "$author",
            'title' => $title,
            'text' => $text,
            'updated_at' => $modification_date);

        Announcement::where('id', $id)->update($data);
        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai redaguotas.'));
    }

    public function destroy($id)
    {
        Announcement::where('id', $id)->delete();
        return redirect()->route('home')->withStatus(__('Pranešimas sėkmingai ištrintas.'));
    }
}

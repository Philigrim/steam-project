<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Announcement;

use App\Event;
use App\LecturerHasEvent;
use App\Reservation;
use App\Subject;
use App\City;

use App\Http\Requests;
use App\Http\Controllers\Controller;
class AnnouncementsController extends Controller
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
        // announcements
        $announcements = Announcement::all()->reverse();

        // promoted events
        $events = Event::where("isPromoted", true);
        $reservations = Reservation::whereIn('event_id', $events->pluck('events.id'))->get();
        $lecturers = LecturerHasEvent::all()->whereIn('event_id', $events->pluck('events.id'))->groupBy('event_id');
        $events = $events->get();
        
        return view('naujienos', ['announcements' => $announcements, 'events'=>$events, 'lecturers'=>$lecturers, 'reservations'=>$reservations]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $announcements = Announcement::where('title', 'like', '%'.$query.'%')
                                     ->orWhere('author', 'like', '%'.$query.'%')
                                     ->orWhere('text', 'like', '%'.$query.'%')
                                     ->orWhere('created_at', 'like', '%'.$query.'%')
                                     ->orderBy('id', 'desc')
                                     ->get();

        // promoted events
        $events = Event::where("isPromoted", true);
        $reservations = Reservation::whereIn('event_id', $events->pluck('events.id'))->get();
        $lecturers = LecturerHasEvent::all()->whereIn('event_id', $events->pluck('events.id'))->groupBy('event_id');
        $events = $events->get();
    
        return view('naujienos', ['search_value' => $query, 'announcements' => $announcements, 'events'=>$events, 'lecturers'=>$lecturers, 'reservations'=>$reservations]);
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

        return redirect()->route('announcements')->withStatus(__('Pranešimas sėkmingai sukurtas.'));
    }

    public function update(Request $request)
    {
        $id = $request->input('edited_id');
        $title = $request->input('edited_title');
        $author = $request->input('edited_author');
        $text = $request->input('edited_text');

        date_default_timezone_set('Europe/Vilnius');
        $modification_date = date('Y/m/d H:i', time());

        $data = array(
            'author' => "$author",
            'title' => $title,
            'text' => $text,
            'updated_at' => $modification_date);

        Announcement::where('id', $id)->update($data);
        return redirect()->route('announcements')->withStatus(__('Pranešimas sėkmingai redaguotas.'));
    }

    public function destroy($id)
    {
        Announcement::where('id', $id)->delete();
        return redirect()->route('announcements')->withStatus(__('Pranešimas sėkmingai ištrintas.'));
    }
}

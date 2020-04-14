<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\City;
use App\SteamCenter;
use App\Room;
class InsertionController extends Controller
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
        $cities = City::all();
        return view('insertion', ['cities'=>$cities]);
    }

    public function insertCity(Request $request)
    {
        City::insert(array('city_name' => $request->get('nameForCity')));
        return redirect()->back()->withStatus(__('Miestas sėkmingai pridėtas.'));
    }

    public function insertSteamCenter(Request $request)
    {
        SteamCenter::insert(array('steam_name' => $request->get('nameForCenter'),
                                  'address' => $request->get('addressForCenter'),
                                  'city_id' => $request->get('cityIdForCenter')));
        return redirect()->back()->withStatus(__('Centras sėkmingai pridėtas.'));
    }

    public function insertRoom(Request $request)
    {
        Room::insert(array('room_number' => $request->get('nameForRoom'),
                                  'capacity' => $request->get('seatsForRoom'),
                                  'steam_center_id' => $request->get('steam_id'),
                                  'course_category' => $request->get('purposeForRoom')));
        return redirect()->back()->withStatus(__('Kambarys sėkmingai pridėtas.'));
    }

    function fetch(Request $request)
    {
    $select = $request->get('select');
    $value = $request->get('value');
    $dependent = $request->get('dependent');

    $city_steam_room = SteamCenter::with('city', 'room')->get();

    $data = $city_steam_room->where($select, $value);

    $output = '<option value="" selected disabled>STEAM Centras</option>';
    foreach ($data as $row) {
        $output .= '<option value="' . $row->id . '">' . $row->steam_name . '</option>';
    }
    echo $output;
    }

}


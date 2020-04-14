<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use App\SteamCenter;
use App\SteamCenterHasRoom;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        $events = Event::all();
//        $steam_center = SteamCenterHasRoom::where('room_id', '=', $events->room_id)->select('steam_id')->get();
//        $address = SteamCenter::where('id', '=', $steam_center[0]->steam_id)->select('address')->get();
//        , ['address'=>$address]
        $count = $events->count()/2;

        if($count == 0){
            $count = 2;
        }

        return view('paskaitos', ['events'=>$events], ['count'=>$count]);
    }

    public function filter(Request $request)
    {
        $capacity = $request->get('filterCapacityInput');
        $category = $request->get('filterCategoryInput');
        $city = $request->get('filterCityInput');

        $events = Event::join('rooms', 'rooms.id', '=', 'events.room_id')
                        ->join('steam_centers', 'steam_centers.id', '=', 'rooms.id')
                        ->join('cities', 'cities.id', '=', 'steam_centers.id')
                        ->join('courses', 'courses.id', '=', 'events.course_id');

        if($category != ''){          
            $events = $events->where('subject', '=', $category);
        }

        if($capacity != ''){          
            $events = $events->where('capacity_left', '>=', $capacity);
        }
        
        if($city != ''){
            $events = $events->where('city_name', '=', $city);
        }

        $events = $events->get();
        
        $count = $events->count()/2;

        if($count == 0){
            $count = 2;
        }

        return view('paskaitos', ['events'=>$events], ['count'=>$count]);
    }
}

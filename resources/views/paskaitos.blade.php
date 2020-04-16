@extends('layouts.app', ['title' => __('Paskaitos')])

@section('additional_header_content')
{{--Gijgo--}}
    <script src="/gijgo/dist/modular/js/core.js" type="text/javascript"></script>
    <link href="/gijgo/dist/modular/css/core.css" rel="stylesheet" type="text/css">

{{--Date pickeris--}}
    <link href="/gijgo/dist/modular/css/datepicker.css" rel="stylesheet" type="text/css">
    <script src="/gijgo/dist/modular/js/datepicker.js"></script>
@endsection

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt-1 ml--5">
        @foreach($events->split($count)->reverse() as $row)
            <div class="flex-row d-inline-flex">
                @foreach($row as $event)
                    <div class="ml-4 bg-gradient-secondary p-2 border-bottom shadow rounded mt-2 col-md-6">
                        <div class="col">
                            <h2>{{ $event->name }}</h2>
                            <div class="flex-row d-inline-flex ml--2 mt--3">
                                <img class="icon-sm pt-3" src="argon/img/icons/common/place.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ 'adresas' }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/clock.svg" alt="">
                                <h5 class="pt-3 pr-2">04.26, 12:00 - 14:00</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/user.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $event->capacity_left }}/{{ $event->room->capacity }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                                <h5 class="pt-3">{{ $event->course->subject }}</h5>
                            </div>
                            <p>{{ $event->description }}</p>
                            <div class="row d-flex justify-content-between">
                                <h3 class="ml-3 pt-3">{{ $event->lecturer->user->firstname }} {{ $event->lecturer->user->lastname }}</h3>
                                <a href="" class="align-self-center"><img src="argon/img/icons/common/document-blue.svg" class="icon-sm" alt=""></a>
                                <button class="btn btn-primary my-2">Registruotis</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

<script type="text/javascript">
    new GijgoDatePicker(document.getElementById('dateFrom'), { calendarWeeks: true, uiLibrary: 'bootstrap4' });
    new GijgoDatePicker(document.getElementById('dateTo'), { calendarWeeks: true, uiLibrary: 'bootstrap4' });
    
    window.onload=function()
    {
    //get the divs to show/hide
    dateFiltersDivs = document.getElementById("dateFilters").getElementsByTagName('div');
    }
     
    function showHide(elem) {
    if(elem.value == "oneDay") {
        //unhide the divs
        dateFiltersDivs[0].style.display = 'flex';
        dateFiltersDivs[2].style.display = 'none';
    } else if(elem.value == "interval"){
        //unhide the divs
        dateFiltersDivs[0].style.display = 'flex';
        dateFiltersDivs[2].style.display = 'flex';
     }
 }
  
 </script>
@endsection


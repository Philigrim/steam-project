@extends('layouts.app', ['title' => __('Paskaitos')])

@section('additional_header_content')
{{--Gijgo--}}
    <script src="/gijgo/dist/modular/js/core.js" type="text/javascript"></script>
    <link href="/gijgo/dist/modular/css/core.css" rel="stylesheet" type="text/css">

{{--Date pickeris--}}
    <link href="/gijgo/dist/modular/css/datepicker.css" rel="stylesheet" type="text/css">
    <script src="/gijgo/dist/modular/js/datepicker.js"></script>

@endsection

@section('additional_header_content')
    <link href="{{ asset('css/win.css') }}" rel="stylesheet" type="text/css" >
    <link href="/css/win.css" rel="stylesheet">
@endsection

@section('content')
    @include('layouts.headers.cards')
    @if (session()->has('message'))
        @if(session()->get('message')==('Jūs jau užsiregistravę į šią paskaitą!'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session()->get('message')==('Jūs sėkmingai užsiregistravote į paskaitą'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endif
    <div class="container pt-2">
      <div class="container pt-2 pl-0 pr-0">

        <!-- Search form -->
        <form action="{{ route('events.search') }}" method="get">
          <div class="input-group mt-3">
            <input class="form-control" name="search" type="text" @if (isset($search_value)) value="{{ $search_value }}" @endif placeholder="Raskite norimą paskaitą">
            <div class="input-group-append">
            <button class="btn"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </form>
      
        @if(isset($filtered) && $filtered == 't')
          <div class="row">
            <form action="{{ route('Paskaitos')}} " method="get">
                <input id="clearFilers" type="submit" class="btn btn-danger ml-3" value="Išvalyti visus filtrus"/>
            </form>
      
            @if(isset($category_value)) <input type="button" class="btn btn-danger ml-3 mb-3" value="Dalykas: {{ $category_value }} (x)" onclick="deleteValue(Category)"></input> @endif
            @if(isset($capacity_value)) <input type="button" class="btn btn-danger ml-3 mb-3" value="Laisvos vietos: bent {{ $capacity_value }} (x)" onclick="deleteValue(Capacity)"></input> @endif
            @if(isset($city_value)) <input type="button" class="btn btn-danger ml-3 mb-3" value="Miestas: {{ $city_value }} (x)" onclick="deleteValue(City)"></input> @endif
            @if(isset($date_value) && (($date_value=="oneDay" && $dateOneDay!="") || ($date_value=="from" && $dateFrom!="") || ($date_value=="till" && $dateTill!="") || ($date_value=="interval" && $dateFrom!="" && $dateTill!="")))
              <input type="button" class="btn btn-danger ml-3 mb-3" value="Data
              @if($date_value=="oneDay") {{ $dateOneDay }} (x)" @endif
              @if($date_value=="from") nuo {{ $dateFrom }} (x)" @endif
              @if($date_value=="till") iki {{ $dateTill }} (x)" @endif
              @if($date_value=="interval") {{ $dateFrom }} - {{ $dateTill }} (x)" @endif
              onclick="deleteValue(dateInput)"></input>
            @endif
          </div>
        @endif
      
        @csrf
            @foreach($reservations as $reservation)
                <div class="card flex-row mb-3" id="{{ $reservation->event->id }}">
                    @if(strlen($reservation->event->description) > 118)
                        <img class="border-0 bg-white rounded-left" width="220" height="211" src="argon/img/brand/steam1-lectures.png" alt="">
                    @else
                        <img class="border-0 bg-white rounded-left" width="216" height="183" src="argon/img/brand/steam1-lectures.png" alt="">
                    @endif
                    <div class="w-100 mb-0 pb-0">
                        <div class="card-header p-0 m-0  win-light-blue">
                            <h2 class="ml-3 pb-0 m-0">{{ $reservation->event->name }}</h2>
                            <div class="ml-3 mb-1 row">
                                <div class="p-0 pl-1 pr-1 bg-primary rounded">
                                    <h6 class="text-white text-center mb-0">{{ $reservation->event->course->course_title }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 win-light-blue">
                            <div class="row ml-1">
                                <img class="icon-sm pt-3" src="argon/img/icons/common/place.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->room->steam->city->city_name }}, {{ $reservation->room->steam->address }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/clock.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->date }}, {{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/user.svg" alt="">
                                @if($reservation->event->capacity_left > 0)
                                    <h5 class="pt-3 pr-2">{{ $reservation->event->capacity_left }}/{{ $reservation->event->max_capacity }}</h5>
                                @else
                                    <h5 class="pt-3 pr-2 text-red">Vietų nėra</h5>
                                @endif
                                <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                                <h5 class="pt-3">{{ $reservation->event->course->subject->subject }}</h5>
                            </div>
                            <div class="ml-3">
                                <p>{{ $reservation->event->description }}</p>
                            </div>
                            <div class="row mt--3 p-0 m-0" id="lecturers">
                                @foreach($lecturers[$reservation->event->id] as $lecturer)
                                    <button class="p-0 shadow--hover ml-3 mb-1 pl-1 pr-1 bg-primary rounded border-0">
                                        <h6 class="text-white text-center mb-0">{{ $lecturer->lecturer->user->firstname }} {{ $lecturer->lecturer->user->lastname }}</h6>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer win-light-blue pb-0 pt-0 mb-0">
                            <div class="row justify-content-between mb--2 p-0">
                                <div class="flex-column mt-1">
                                      @if(isset($reservation->event->file_id))
                                        <div class="form-group">
                                          <i class="fa fa-file" style="font-size:24px"></i>     
                                          <a href = "{{route('downloadFile',$reservation->event->file->id)}}"  id = "hyper">Dėstytojo pridėtas failas</a>
                                        </div>
                                      @endif   
                                </div>
                                <div class="flex-column">
                                    @if(Auth::user()->isRole() === 'mokytojas')
                                        <button href ="#" data-id="{{$reservation->event->id}}" data-capacity= "{{$reservation->event->capacity_left}}"class="show-modal p-1 btn btn-primary my-2 exampleModalCenter" id="lol" data-name="{{$reservation->event->name}}">Registruotis</button>
                                    @else
                                        <button disabled href ="#" data-id="{{$reservation->event->id}}" data-capacity= "{{$reservation->event->capacity_left}}"class="show-modal p-1 btn btn-light my-2 exampleModalCenter" id="lol" data-name="{{$reservation->event->name}}">Registruotis</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            {{ csrf_field() }}
        @endforeach
<div class="row">
  <div class ="col-12 d-flex justify-content-center">
  {{$reservations->links()}}
  </div>
</div>


    </div>
    <div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Regitracija į paskaitą</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action = "/paskaitos" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Paskaitos pavadinimas :</label>
                            <b id ="name"/>
                        </div>
                        <div class="form-group">
                            <input  type="hidden"type="text" name="event_id" id="id">
                        </div>
                        <br>
                        <div class="form-group">
                            <b>Mokinių skaičius</b>
                            <input id='set-capacity'name ="pupil_count" class="col-5" value ="1" min="1" type="number" placeholder="0" min="0">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit"  class="btn btn-success mt-4">{{ __('Patvirtinti') }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- Modal Form Show POST
        <div id="show" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"></h4>
                          </div>
                            <div class="modal-body">

                            <div class="form-group">
                              <label for="">Title :</label>
                              <b id="name"/>
                              <a href="#" class="show-modal btn btn-info btn-sm" data-id="{{$event->id}}" data-name="{{$event->name}}">
                                <i class="fa fa-eye"></i>
                              </a>
                            </div>

                            </div>
                            </div>
                          </div>
        </div> --}}
        @endsection

        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
        <script type="text/javascript">
            $(document).on('click', '.show-modal', function() {
                $('#show').modal('show');
                $('#id').val($(this).data('id'));
                $('#name').text($(this).data('name'));
                $('#set-capacity').attr("max",$(this).data('capacity'));
            })
        </script>

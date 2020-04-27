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
        @foreach($reservations as $reservation)
            @csrf
                <div class="card shadow mb-1 border rounded w-100 d-flex">
                    @if($reservation->event->capacity_left > "0")
                        <a href ="#" data-id="{{$reservation->event->id}}" data-capacity= "{{$reservation->event->capacity_left}}"class="text-darker show-modal exampleModalCenter" id="lol" data-name="{{$reservation->event->name}}">
                            <div class="d-flex win-card-link-active">
                    @else
                        <div class="d-inline-flex win-light-red">
                    @endif
                            <div class="p-0 m-0 flex-column">
                                <img class="img-center border-0 bg-white rounded-left" width="160" height="160" src="argon/img/brand/steam1-lectures.png" alt="">
                            </div>
                            <div class="m-0 w-100 flex-column">
                                <div class="card-header mb-0 pb-2">
                                    <h3 class="m--3 pb-3">{{ $reservation->event->name }}</h3>
                                    <div class="row">
                                        <div class="p-0 pl-1 pr-1 bg-primary rounded">
                                            <h6 class="text-white text-center mb-0">{{ $reservation->event->course->course_title }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pb-0 mt--2" style="height: 72%">
                                    <div class="row mt--4 ml--4">
                                        <img class="icon-sm pt-3" src="argon/img/icons/common/place.svg" alt="">
                                        <h5 class="pt-3 pr-2">{{ $reservation->room->steam->city->city_name }}, {{ $reservation->room->steam->address }}</h5>
                                        <img class="icon-sm pt-3" src="argon/img/icons/common/clock.svg" alt="">
                                        <h5 class="pt-3 pr-2">{{ $reservation->date }}, {{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</h5>
                                        <img class="icon-sm pt-3" src="argon/img/icons/common/user.svg" alt="">
                                        @if($reservation->event->capacity_left > "0")
                                            <h5 class="pt-3 pr-2">{{ $reservation->event->max_capacity - $reservation->event->capacity_left }}/{{ $reservation->event->max_capacity }}</h5>
                                        @else
                                            <h5 class="pt-3 pr-2 text-red">Vietų nėra</h5>
                                        @endif
                                        <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                                        <h5 class="pt-3">{{ $reservation->event->course->subject->subject }}</h5>
                                    </div>
                                    <div class="row mt--2">
                                        <p>{{ $reservation->event->description }}</p>
                                    </div>
                                    
                                    <div class="row pb-1 mt--2" id="lecturers">
                                        @foreach($lecturers[$reservation->event->id] as $lecturer)
                                            <div class="p-0 pb pl-1 pr-1 mr-2 bg-primary rounded align-self-baseline">
                                                <h6 class="text-white text-center mb-0">{{ $lecturer->lecturer->user->firstname }} {{ $lecturer->lecturer->user->lastname }}</h6>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    @if($reservation->event->capacity_left > "0")
                        </a>
                    @endif
            </div>
{{--                <div class="card-footer bg-secondary p-0">--}}
{{--                    <div class="col">--}}
{{--                        <div class="d-flex justify-content-between">--}}
{{--                            <a href="" class="align-self-center"><img src="argon/img/icons/common/document-blue.svg" class="icon-sm" alt=""></a>--}}
{{--                            --}}{{----}}{{--                        @if(Auth::user()->isRole() === 'mokytojas')--}}
{{--                            @if($reservation->event->capacity_left > "0")--}}
{{--                                <button href ="#" data-id="{{$reservation->event->id}}" data-capacity= "{{$reservation->event->capacity_left}}"class="show-modal btn p-2 btn-primary my-2 exampleModalCenter" id="lol" data-name="{{$reservation->event->name}}">Registruotis</button>--}}
{{--                            @else--}}
{{--                                <button class="show-modal btn btn-primary my-2 exampleModalCenter" id="lol"  disabled>Registruotis</button>--}}
{{--                            @endif--}}
{{--                            --}}{{----}}{{--                        @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
        {{ csrf_field() }}
        @endforeach

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
             <input id="set-capacity" name ="pupil_count" class="col-5" value ="1" min="1" max="1" type="number" placeholder="0">
               </div>
               <br>
               <div class="form-group">
                <b> Pridėti failai: </b>
                <br>
                <i class="fa fa-file" style="font-size:24px"></i>     
                <a href = "{{route('downloadFile',$reservation->event->file->id)}}">{{ $reservation->event->file->name }}</a>
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
  <script type="text/javascript">
    new GijgoDatePicker(document.getElementById('dateFrom'), { calendarWeeks: true, uiLibrary: 'bootstrap4', format: 'yyyy-mm-dd' });
    new GijgoDatePicker(document.getElementById('dateTo'), { calendarWeeks: true, uiLibrary: 'bootstrap4', format: 'yyyy-mm-dd' });

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

    $('#set-capacity').change(function(){
        if(parseInt($().val('#set-capacity')) > parseInt($('#set-capacity').attr("max"))){
            $('#set-capacity').val($('#set-capacity').attr("max"));
        }else if($('#set-capacity').val() < $('#set-capacity').attr("min")){
            $('#set-capacity').val($('#set-capacity').attr("min"));
        }
    })
</script>

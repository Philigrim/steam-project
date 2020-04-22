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
    <div class="container pt-2 ml-3 w-50">
        <table class="table">
            <tbody>
            @foreach($reservations as $reservation)
                @csrf
                <tr>
                    <div class="row mr-2 mt-1 border shadow rounded win-event bg-gradient-white" id="{{ $reservation->event->id }}">
                        <div class="col-md-12 pl--7 ml-0">
                            <div class="">
                                <h3>{{ $reservation->event->name }}</h3>
                            </div>
                            <div class="row mt--3 ml-1">
                                <img class="icon-sm pt-3" src="argon/img/icons/common/place.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->room->steam->city->city_name }}, {{ $reservation->room->steam->address }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/clock.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->date }}, {{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/user.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->event->max_capacity - $reservation->event->capacity_left }}/{{ $reservation->event->max_capacity }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                                <h5 class="pt-3">{{ $reservation->event->course->subject->subject }}</h5>
                            </div>
                            <div class="">
                                <p>{{ $reservation->event->description }}</p>
                            </div>
                            <div class="row mt--4" id="lecturers">
                                @foreach($lecturers[$reservation->event->id] as $lecturer)
                                    <button class="ml-3 p-1 mt-3 btn btn-dark my-2">
                                        <h6 class="text-white text-center mb-0">{{ $lecturer->lecturer->user->firstname }} {{ $lecturer->lecturer->user->lastname }}</h6>
                                    </button>
                                @endforeach
                            </div>
                            <div class="row justify-content-center border-top">
                                <div class="col-4">
                                    <a href="" class="align-self-center"><img src="argon/img/icons/common/document-blue.svg" class="icon-sm" alt=""></a>
                                    @if(Auth::user()->isRole() === 'mokytojas')
                                      @if($reservation->event->capacity_left>"0")
                                        <button href ="#" data-id="{{$reservation->event->id}}" data-capacity= "{{$reservation->event->capacity_left}}"class="show-modal btn btn-primary my-2 exampleModalCenter" id="lol" data-name="{{$reservation->event->name}}">Registruotis</button>
                                      @endif
                                      @if($reservation->event->capacity_left=="0")
                                      <button class="show-modal btn btn-primary my-2 exampleModalCenter" id="lol"  disabled ">Registruotis</button>

                                      @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
            </tbody>
        </table>
        {{ csrf_field() }}
        @endforeach
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
             <input id="set-capacity" name ="pupil_count" class="col-5" value ="1" min="1" max="1" type="number" placeholder="0">
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

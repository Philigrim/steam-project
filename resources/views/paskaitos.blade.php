@extends('layouts.app')

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
                                <h5 class="pt-3 pr-2">{{ $event->capacity_left }}/{{ $event->max_capacity }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                                <h5 class="pt-3">{{ $event->course->subject }}</h5>
                            </div>
                            <p>{{ $event->description }}</p>
                            <div class="row d-flex justify-content-between">
                                <h3 class="ml-3 pt-3">{{ $event->lecturer->user->firstname }} {{ $event->lecturer->user->lastname }}</h3>
                                <a href="" class="align-self-center"><img src="argon/img/icons/common/document-blue.svg" class="icon-sm" alt=""></a>
                                <button href ="#" data-id="{{$event->id}}" class="show-modal btn btn-primary my-2 exampleModalCenter" id="lol" data-name="{{$event->name}}">Registruotis</button>
                            </div>
                            {{-- <a href="#" class="show-modal btn btn-info btn-sm"  data-name="{{$event->name}}">
                              <i class="fa fa-eye"></i>
                            </a> --}}
                          </div>
                    </div>
                @endforeach
            </div>
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
             <input name ="pupil_count" class="col-5" type="number" placeholder="0" min="0">
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
<script type="text/javascript">
  $(document).on('click', '.show-modal', function() {
  $('#show').modal('show');
  $('#id').val($(this).data('id'));
  $('#name').text($(this).data('name'));})
    
  
    </script>

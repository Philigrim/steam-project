@extends('layouts.app')

@section('additional_header_content')

{{--Gijgo--}}
{{--Date pickeris--}}
    <script src="/gijgo/dist/modular/js/core.js" type="text/javascript"></script>
    <link href="/gijgo/dist/modular/css/core.css" rel="stylesheet" type="text/css">
    <link href="/gijgo/dist/modular/css/datepicker.css" rel="stylesheet" type="text/css">
    <script src="/gijgo/dist/modular/js/datepicker.js"></script>

{{--Drop downas--}}
    <link href="/gijgo/dist/modular/css/dropdown.css" rel="stylesheet" type="text/css">
    <script src="/gijgo/dist/modular/js/dropdown.js"></script>

{{--Nedulio skriptai--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@endsection

@section('content')
    @include('users.partials.header', ['title' => __('Sukurti paskaitą')])
    <div class="container-fluid mt--7 row d-flex justify-content-center">
        <div class="col-xl-6 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            @if (session()->has('message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session()->get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <h2 class="col-12 mb-0">{{ __('Informacija apie kursą') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form action = "/eventai" method="post">
                        @csrf<div class="col-md-12  ">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Paskaitos pavadinimas" name="name" required>
                                </div>
                            </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control dropdown-menu-arrow" name="course_id" required>
                                    <option value="" selected disabled>Kursas</option>
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->course_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control dropdown-menu-arrow" name="city_id" id ="city_id" required>
                                    <option value="" selected disabled>Miestas</option>
                                    @foreach($cities as $key=> $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control dropdown-menu-arrow" name="steam_id" id="steam_id" required>
                                            <option value="" selected disabled>Steam centras</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="dropdown" width="200">Destytojas</select>
                                        <script>
                                            $('#dropdown').dropdown({
                                                textField: 'newTextField',
                                                dataSource: [ { value: 1, newTextField: 'One' }, { value: 2, newTextField: 'Two' }, { value: 3, newTextField: 'Three' } ]
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select class="form-control dropdown-menu-arrow" name="room_id" id="room_id" required>
                                                <option value="" selected disabled>Kambarys </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input id="datepicker" width="234" />
                                    <script>
                                        new GijgoDatePicker(document.getElementById('datepicker'), { calendarWeeks: true, uiLibrary: 'bootstrap4' });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Apie kursą ..." name="description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Patvirtinti') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @include('layouts.footers.auth')
        </div>
    </div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript">
    jQuery(document).ready(function ()
    {
            jQuery('select[name="city_id"]').on('change',function(){
               var cityID = jQuery(this).val();
               if(cityID)
               {
                  jQuery.ajax({
                     url : 'findSteamCenter/' +cityID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="steam_id"]').empty();
                        jQuery('select[name="steam_id"]').append('<option value="">Steam centras</option>');

                        jQuery.each(data, function(key,value){
                           $('select[name="steam_id"]').append('<option value="'+ key +'">'+ value +'</option>');
5                        });
                        }
                  });
               }
               else
               {
                  $('select[name="steam_id"]').empty();
                  $('select[name="room"]').empty();
                  jQuery('select[name="room"').append('<option value="">kambarys</option>'); 
               }
            });
            jQuery('select[name="steam_id"]').on('change',function(){
               var steamID = jQuery(this).val();
               if(steamID)
               {
                  jQuery.ajax({ 
                     url : 'findRoom/' +steamID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="room_id"]').empty();
                        jQuery('select[name="room_id"').append('<option value="">Kambarys</option>'); 

                        jQuery.each(data, function(key,value){
                           $('select[name="room_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="room"]').empty();
               }
            });
            JQuery('select[name=""]')
    });
    </script>

@endsection

@extends('layouts.app')

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
                    <form action = "/home" method="post">
                        @csrf<div class="col-md-12  ">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Paskaitos pavadinimas" name="course_title" required>
                                </div>
                            </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control dropdown-menu-arrow" name="lecturer_id" required>
                                    <option value="" selected disabled>Kursas</option>
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->course_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control dropdown-menu-arrow" name="city" id ="city" required>
                                    <option value="" selected disabled>Miestas</option>
                                    @foreach($cities as $key=> $value)
                                        <option value="{{$key}}">{{ucfirst($value)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control dropdown-menu-arrow" name="steam" id="steam" required>
                                            <option value="" selected disabled>Steam centras</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control dropdown-menu-arrow" name="room" id="room" required>
                                            <option value="" selected disabled>Kambarys </option>
                                           
                                        </select>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Papildoma informacija ..." name="comments" required></textarea>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ()
    {
            jQuery('select[name="city"]').on('change',function(){
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
                        jQuery('select[name="steam"]').empty();
                        jQuery('select[name="steam"').append('<option value="">Steam centras</option>'); 

                        jQuery.each(data, function(key,value){
                           $('select[name="steam"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        }
                  });
               }
               else
               {
                  $('select[name="steam"]').empty();
                  $('select[name="room"]').empty();
                  jQuery('select[name="room"').append('<option value="">kambarys</option>'); 
               }
            });
            jQuery('select[name="steam"]').on('change',function(){
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
                        jQuery('select[name="room"]').empty();
                        jQuery('select[name="room"').append('<option value="">kambarys</option>'); 

                        jQuery.each(data, function(key,value){
                           $('select[name="room"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="room"]').empty();
               }
            });
    });
    </script>
 
@endsection

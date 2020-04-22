@extends('layouts.app')

@section('additional_header_content')

{{--Gijgo--}}
    <script src="/gijgo/dist/modular/js/core.js" type="text/javascript"></script>
    <link href="/gijgo/dist/modular/css/core.css" rel="stylesheet" type="text/css">

{{--Date pickeris--}}
    <link href="/gijgo/dist/modular/css/datepicker.css" rel="stylesheet" type="text/css">
    <script src="/gijgo/dist/modular/js/datepicker.js"></script>

{{--Nedulio skriptai--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@endsection

@section('content')
    @include('users.partials.header', ['title' => __('Sukurti paskaitą')])
        <form class="mt--5 d-flex justify-content-center" action = "/sukurti-paskaita" method="post">
            @csrf
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
                            <h2 class="col-12 mb-0">{{ __('Informacija apie paskaitą') }}</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-start">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Paskaitos pavadinimas" name="name" >
                                </div>
                            </div>
                            @if ($errors->has('description'))
                                <div class="">
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ "Aprašymas yra privalomas" }}</strong>
                                    </span>
                                </div>
                                @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select onload="update_dropdown()" class="form-control dropdown-menu-arrow dynamic-lecturers" name="course_id" id="course_id" data-dependent="lecturer_id"  required>
                                        <option value="" selected disabled>{{ "Kursai" }}</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-start">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow dynamic-ccr" name="city_id" id ="city_id" data-dependent="steam_id" required>
                                        <option value="" selected disabled>Miestas</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow dynamic-ccr" name="steam_id" id="steam_id" data-dependent="room_id" required>
                                        <option value="" selected disabled>STEAM centras</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow update-time" name="room_id" id="room_id"required>
                                        <option selected disabled>Kambarys</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-start">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class=" form-group form-control input-group update-time" name="date" placeholder="Data" id="datepicker" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="time" id="time" class="form-control dropdown-menu-arrow" required>
                                        <option selected disabled>Laikas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control input-group" type="number" min="1" name="capacity" value="1" placeholder="Žmonių skaičius">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Apie kursą ..." name="description" maxlength="200" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Patvirtinti') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h2 class="col-12 mb-0">{{ __('Dėstytojai') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            @if ($errors->has('lecturers'))
                                <div class="ml-4">
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ "Pasirinkite bent 1 dėstytoją." }}</strong>
                                            </span>
                                </div>
                            @endif
                            <div class="form-group">
                                <table class="table table-sm align-items-center table-scroll" id="lecturer_id"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript">
    new GijgoDatePicker(document.getElementById('datepicker'), { uiLibrary: 'bootstrap4', format: 'yyyy-dd-mm' });

    $('.dynamic-lecturers').change(function update_lecturers(){
        if($(this).val() != ''){
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token').val();
            $.ajax({
                url:"{{ route('createeventcontroller.fetch_lecturers') }}",
                method: "POST",
                data:{select:select, value:value, _token:_token},
                success:function(result){
                    $('#'+dependent).html(result);
                }
            })
        }
    })

    $('.dynamic-ccr').change(function update_multi_dropdown(){
        if($(this).val() != ''){
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token').val();
            $.ajax({
                url:"{{ route('createeventcontroller.fetch') }}",
                method: "POST",
                data:{select:select, value:value, _token:_token, dependent:dependent},
                success:function(result){
                    $('#room_id').html('<option value="" selected disabled>Kambarys</option>')
                    $('#time').html('<option value="" selected disabled>Laikas</option>');
                    $('#'+dependent).html(result);
                }
            })
        }
    })

    $('.update-time').change(function update_time(){
        if($(this).val() != ''){
            var room_value = $('#room_id').val();
            var date_value = $('#datepicker').val();
            if(room_value != null && date_value != ''){
                var _token = $('input[name="_token').val();
                $.ajax({
                    url:"{{ route('createeventcontroller.fetch_time') }}",
                    method: "POST",
                    data:{room_value:room_value, date_value:date_value, _token:_token},
                    success:function(result){
                        $('#time').html(result);
                    }
                })
            }
        }else{
            $('#time').html('<option value="" selected disabled>Laikas</option>');
        }
    })
</script>

@endsection

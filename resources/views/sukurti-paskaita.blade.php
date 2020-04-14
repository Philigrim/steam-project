@extends('layouts.app')

@section('additional_header_content')

{{--Gijgo--}}
    <script src="/gijgo/dist/modular/js/core.js" type="text/javascript"></script>
    <link href="/gijgo/dist/modular/css/core.css" rel="stylesheet" type="text/css">

{{--Date pickeris--}}
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
                        <h2 class="col-12 mb-0">{{ __('Informacija apie paskaitą') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form action = "/sukurti-paskaita" method="post">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control" placeholder="Paskaitos pavadinimas" name="name" required>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select onload="update_dropdown()" class="form-control dropdown-menu-arrow dynamic" name="course_id" id="course_id" data-dependent="lecturer_id" required>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow dynamic" name="course_id" id="course_id" data-dependent="lecturer" required>
                                        <option value="" selected disabled>Destytojas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow dynamic" name="city_id" id ="city_id" data-dependent="steam_id" required>
                                        <option value="" selected disabled>Miestas</option>
                                        @foreach($city_steam_room as $city)
                                            <option value="{{ $city[0]->city->id}}">{{ $city[0]->city->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow dynamic" name="steam_id" id="steam_id" data-dependent="room_id" required>
                                        <option value="" selected disabled>STEAM centras</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow" name="room_id" id="room_id"required>
                                        <option value="" selected disabled>Kambarys</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input placeholder="Data" id="datepicker"/>
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
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            @include('layouts.footers.auth')
        </div>
    </div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript">
    new GijgoDatePicker(document.getElementById('datepicker'), { calendarWeeks: true, uiLibrary: 'bootstrap4' });

    $('.dynamic').change(function update_dropdown(){
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
                    $('#'+dependent).html(result);
                }
            })
        }
    })
</script>

@endsection

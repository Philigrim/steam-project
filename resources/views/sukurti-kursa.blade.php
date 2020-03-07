@extends('layouts.app')

@section('content')
    @include('users.partials.header', ['title' => __('Sukurti kursą'),
             'description' => __('Kursų kurimo puslapis. Sukurti kursai bus naudojami kuriant paskaitas.')])

    <div class="container-fluid mt--7">
        <form class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('course_title') ? ' has-danger' : '' }}">
                        <div class="input-group input-group-alternative mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                            </div>
                            <input class="form-control{{ $errors->has('course_title') ? ' is-invalid' : '' }}" placeholder="{{ __('Kurso pavadinimas') }}" type="text" name="course_title" value="{{ old('course_title') }}" required autofocus>
                        </div>
                        @if ($errors->has('course_title'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('course_title') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control dropdown-menu-arrow">
                            <option value="Placeholder" selected disabled>Dalykas</option>
                            <option value="Physics">Fizika</option>
                            <option value="Biology">Biologija</option>
                            <option value="Engineering">Inžinerija</option>
                            <option value="Informatics">Informatika</option>
                            <option value="Chemistry">Chemija</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Apie kursą ..."></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Reikalinga įranga ..."></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Papildoma informacija ..."></textarea>
                    </div>
                </div>
            </div>
        </form>
        @include('layouts.footers.auth')
    </div>
@endsection

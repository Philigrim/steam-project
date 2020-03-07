@extends('layouts.app')

@section('content')
    @include('users.partials.header', ['title' => __('Sukurti kursą'),
             'description' => __('Kursų kurimo puslapis. Sukurti kursai bus naudojami kuriant paskaitas.')])

    <div class="container-fluid mt--7">
        <form action = "/home" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input class="form-control" placeholder="Vardas" name="lecturer_name" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input class="form-control" placeholder="Pavardė" name="lecturer_last_name" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input class="form-control" placeholder="Kurso pavadinimas" name="course_title" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control dropdown-menu-arrow" name="subject" required>
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
                        <textarea class="form-control" rows="5" placeholder="Apie kursą ..." name="description" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Reikalinga įranga ..." name="equipment" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Papildoma informacija ..." name="comments" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mt-4 text-center">{{ __('Patvirtinti') }}</button>
                    </div>
                </div>
            </div>
        </form>
        @include('layouts.footers.auth')
    </div>
@endsection

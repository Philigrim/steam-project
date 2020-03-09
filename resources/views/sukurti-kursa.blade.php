@extends('layouts.app')

@section('content')
    @include('users.partials.header', ['title' => __('Sukurti kursą'),
             'description' => __('Kursų kurimo puslapis. Sukurti kursai bus naudojami kuriant paskaitas.')])
    <div class="container-fluid mt--7">
        <div class="col-xl-6 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h2 class="col-12 mb-0">{{ __('Informacija apie kursą') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form action = "/home" method="post">
                        @csrf
                        <label>Vienas fieldas search/dropdown pull from database Destytoju vardus?</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Vardas" name="lecturer_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Pavardė" name="lecturer_last_name" required>
                                </div>
                            </div>
                        </div>
                        <label>Patikrinti ar toks pavadinimas jau egzistuoja</label>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Kurso pavadinimas" name="course_title" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control dropdown-menu-arrow" name="subject" required>
                                        <option value="" selected disabled>Dalykas</option>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Apie kursą ..." name="description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <label>Ideju kitaip uzpildyti info apie iranga. Iranga ir papildoma info rodyti tik adminui/adminui ir destytojam</label>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Reikalinga įranga ..." name="equipment" required></textarea>
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
@endsection

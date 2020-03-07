@extends('layouts.app')

@section('content')
    <form class="col-md-9 pt-8 ml-9">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" placeholder="Kurso pavadinimas">
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
@endsection

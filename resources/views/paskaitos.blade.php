@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt-1 ml--5">
        <div class="flex-row d-inline-flex">
            <div class="ml-4 bg-gradient-secondary p-2 border-bottom shadow rounded mt-2 col-md-6">
                <div class="col">
                    <h2>Lore ipsum dolor</h2>
                    <div class="flex-row d-inline-flex ml--2 mt--3">
                        <img class="icon-sm pt-3" src="argon/img/icons/common/place.svg" alt="">
                        <h5 class="pt-3 pr-2">Didlaukio 59-101, Vilnius</h5>
                        <img class="icon-sm pt-3" src="argon/img/icons/common/clock.svg" alt="">
                        <h5 class="pt-3 pr-2">04.26, 12:00 - 14:00</h5>
                        <img class="icon-sm pt-3" src="argon/img/icons/common/user.svg" alt="">
                        <h5 class="pt-3 pr-2">10/15</h5>
                        <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                        <h5 class="pt-3">Informatika</h5>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <div class="row d-flex justify-content-between">
                        <h3 class="ml-3 pt-3">Rikas Sančezas</h3>
                        <a href="" class="align-self-center"><img src="argon/img/icons/common/document-blue.svg" class="icon-sm" alt=""></a>
                        <button class="btn btn-primary my-2">Registruotis</button>
                    </div>
                </div>
            </div>
            <div class="ml-4 bg-gradient-secondary p-2 border-bottom shadow rounded mt-2 col-md-6 flex-sm-wrap">
                <div class="col">
                    <h2>Lore ipsum dolor</h2>
                    <div class="flex-row d-inline-flex ml--2 mt--3">
                        <img class="icon-sm pt-3" src="argon/img/icons/common/place.svg" alt="">
                        <h5 class="pt-3 pr-2">Didlaukio 59-101, Vilnius</h5>
                        <img class="icon-sm pt-3" src="argon/img/icons/common/clock.svg" alt="">
                        <h5 class="pt-3 pr-2">04.26, 12:00 - 14:00</h5>
                        <img class="icon-sm pt-3" src="argon/img/icons/common/user.svg" alt="">
                        <h5 class="pt-3 pr-2">15</h5>
                        <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                        <h5 class="pt-3">Informatika</h5>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <div class="row d-flex justify-content-between align-self-end">
                        <h3 class="ml-3 pt-3">Rikas Sančezas</h3>
                        <a href="" class="align-self-center"><img src="argon/img/icons/common/document-blue.svg" class="icon-sm" alt=""></a>
                        <button class="btn btn-primary my-2">Registruotis</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

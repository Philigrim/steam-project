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
                                <h5 class="pt-3 pr-2">{{ $event->capacity_left }}/{{ $event->room->capacity }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                                <h5 class="pt-3">{{ $event->course->subject }}</h5>
                            </div>
                            <p>{{ $event->description }}</p>
                            <div class="row d-flex justify-content-between">
                                <h3 class="ml-3 pt-3">{{ $event->lecturer->user->firstname }} {{ $event->lecturer->user->lastname }}</h3>
                                <a href="" class="align-self-center"><img src="argon/img/icons/common/document-blue.svg" class="icon-sm" alt=""></a>
                                <button class="btn btn-primary my-2">Registruotis</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection

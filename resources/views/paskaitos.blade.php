@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt-1 ml--5">
        @foreach($reservations->split($count)->reverse() as $row)
            <div class="flex-row d-inline-flex">
                @foreach($row as $reservation)
                    <div class="ml-4 bg-gradient-secondary p-2 border-bottom shadow rounded mt-2 col-md-6">
                        <div class="col">
                            <h2>{{ $reservation->event->name }}</h2>
                            <div class="flex-row d-inline-flex ml--2 mt--3">
                                <img class="icon-sm pt-3" src="argon/img/icons/common/place.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->room->find_steam->steam->address }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/clock.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->date }}, {{ $reservation->start_time }} - {{ $reservation->end_time }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/user.svg" alt="">
                                <h5 class="pt-3 pr-2">{{ $reservation->event->capacity_left }}/{{ $reservation->event->max_capacity }}</h5>
                                <img class="icon-sm pt-3" src="argon/img/icons/common/book.svg" alt="">
                                <h5 class="pt-3">{{ $reservation->event->course->subject }}</h5>
                            </div>
                            <p>{{ "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum." }}</p>
                            <div class="row d-flex justify-content-between">
                                <h3 class="ml-3 pt-3">{{ $reservation->event->lecturer->lecturer->user->firstname }} {{ $reservation->event->lecturer->lecturer->user->lastname }}</h3>
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

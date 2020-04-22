@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Sveikas') . ', '. auth()->user()->firstname . ',',
        'description' => __('Šiame puslapyje galite apžvelgti praėjusias ir būsimas paskaitas, taip pat matyti, kur ir kada jos vyko.'),
        'class' => 'col-lg-7'
    ])

    <div class="container-fluid mt--7" style="left:0">
        <div class="col-xl-13 order-xl-1 mt-3">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="col-12 mb-0">{{ __('Paskaitos') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="column pl-lg-4">
                        <table style="width:100%">
                            <tr>
                                <th><p class="heading-small text-muted mb-4" style="font-weight:bold">{{ __('Būsimos paskaitos') }}</p></th>
                            </tr>
                            <tr>
                                <th>Paskaitos pavadinimas:</th>
                                <th>Destytojas:</th>
                                <th>Data ir laikas:</th>
                                <th>Užregistruota dalyvių:</th>
                                <th>Visų dalyvių skaičius:</th>
                                <th>Miestas:</th>
                                <th>Adresas:</th>
                                <th>Centras:</th>
                                <th>Kabinetas:</th>
                            </tr>
                            @foreach($futureEvents as $reservation)
                            <tr style="font-weight:normal">
                                <th style="font-weight:normal">{{ $reservation->event->name}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->lecturer->lecturer->user->firstname }} {{ $reservation->event->lecturer->lecturer->user->lastname }}</th>
                                <th style="font-weight:normal">{{ $reservation->date }}, {{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</th>
                                <th style="font-weight:normal">{{ $reservation->event->teacher->pupil_count }}</th>
                                <th style="font-weight:normal">{{ $reservation->event->capacity_left }} / {{ $reservation->event->max_capacity }}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->steam->city->city_name}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->steam->address}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->steam->steam_name}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->room_number}}</th>
                            </tr>
                            @endforeach
                            <tr>
                                <th><p class="heading-small text-muted mt-5" style="font-weight:bold">{{ __('Praėjusios paskaitos') }}</p></th>
                            </tr>
                            <tr>
                                <th>Paskaitos pavadinimas:</th>
                                <th>Destytojas:</th>
                                <th>Data ir laikas:</th>
                                <th>Užregistruota dalyvių:</th>
                                <th>Visų dalyvių skaičius:</th>
                                <th>Miestas:</th>
                                <th>Adresas:</th>
                                <th>Centras:</th>
                                <th>Kabinetas:</th>
                            </tr>
                            @foreach($pastEvents as $reservation)
                            <tr>
                                <th style="font-weight:normal">{{ $reservation->event->name}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->lecturer->lecturer->user->firstname }} {{ $reservation->event->lecturer->lecturer->user->lastname }}</th>
                                <th style="font-weight:normal">{{ $reservation->date }}, {{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</th>
                                <th style="font-weight:normal">{{ $reservation->event->teacher->pupil_count }}</th>
                                <th style="font-weight:normal">{{ $reservation->event->capacity_left }} / {{ $reservation->event->max_capacity }}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->steam->city->city_name}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->steam->address}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->steam->steam_name}}</th>
                                <th style="font-weight:normal">{{ $reservation->event->room->room_number}}</th>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    
            </div>
        </div>
    </div>
@endsection
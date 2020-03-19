@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid">
    @foreach ($courses->split($courses->count()/2)->reverse() as $row)

            <div class="row">
                @foreach($row as $info)
                    <div class="col-md-6">
                        <div class="card card-stats mt-3">
                            <div class="card-body border border-primary rounded">
                                <div class="col">
                                    <h1>
                                        <span class="h2 font-weight-bold mb-0 d-flex justify-content-center"><td>{{ $info->course->course_title }}</td></span>
                                    </h1>
                                </div>

                                <div class="d-flex flex-r ml-2 mt-3 mt">
                                    <div class="mb-0 text-muted text-sm">
                                        <h3>Aprašymas:</h3>
                                    </div>
                                    <div class="ml-3">{{ $info->course->description }}</div>
                                </div>

                                <div class="d-flex flex-row ml-2 mt-3 mt">
                                    <div class="mb-0 text-muted text-sm">
                                        <h3>Dėstytojas:</h3>
                                    </div>
                                    <div class="ml-3">{{$info->lecturer->user->firstname}} {{$info->lecturer->user->lastname}}</div>
                                </div>
                                <div class="text-center ">
                                    <button type="submit" class="btn btn-primary my-4">Registruotis</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

    @endforeach
    </div>
@endsection

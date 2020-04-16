@extends('layouts.app', ['title' => __('Kursai')])

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid">
    @foreach ($courses->split($count)->reverse() as $row)
            <div class="row">
                @foreach($row as $course)
                    <div class="col-md-6">
                        <div class="card card-stats mt-3">
                            <div class="card-body border border-primary rounded">
                                <div class="col">
                                    <h1>
                                        <span class="h2 font-weight-bold mb-0 d-flex justify-content-center"><td>{{ $course->course_title }}</td></span>
                                    </h1>
                                </div>

                                <div class="d-flex flex-r ml-2 mt-3 mt">
                                    <div class="mb-0 text-muted text-sm ">
                                        <h3>Aprašymas:</h3>
                                    </div>
                                    <div class="ml-3">{{ $course->description }}</div>
                                </div>
                                <div class="d-flex flex-r ml-2 mt-3 mt">
                                    <div class="mb-0 text-muted text-sm ">
                                        <h3>Aprašymas:</h3>
                                    </div>
                                    <div class="ml-3">{{ $course->comments }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    @endforeach
@endsection

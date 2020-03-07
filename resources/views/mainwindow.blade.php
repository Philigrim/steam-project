@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    @foreach ($courses as $course)
    <tr>
    <td>{{ $course->title }}</td>
    </tr>
    @endforeach
    @foreach ($courses as $course)
    <tr> 
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                    <span class="h2 font-weight-bold mb-0"><td>{{ $course->title }}</td></span>
                </div>
                <td>Description :{{ $course->description }}</td>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                <span class="text-nowrap"><td>{{ $course->lecturer_name }}</td></span>
            </p>
        </div>
    </div> 
    </tr>
    @endforeach
@endsection

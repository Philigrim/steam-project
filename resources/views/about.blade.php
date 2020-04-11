@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-6">
                        <h1 class="text-white">{{ __('About STEAM project') }}</h1>
                        <br>
                        <h2 class="text-white">{{ __('The STEAM is fully-integrated learning environment where everything from the equipment and technology to curriculum and assessment work together to support hands-on, minds-on learning. The educational institution provides courses related to Science, Technology, Engineering, Arts and Mathematics to enhance pupils\' logical and critical thinking, problem solving, communication and adaptability skills.') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection

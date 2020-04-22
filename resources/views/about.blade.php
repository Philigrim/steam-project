@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-6">
                        <h1 class="text-white">{{ __('Apie STEAM projektą') }}</h1>
                        <br>
                        <h2 class="text-white">{{ __('STEAM tai pilnai integruota mokymosi sistema, kurioje viskas: nuo mokymosi įrangos ir naudojamų technologijų iki ugdymo plano ir vertinimo sistemos, dirba glaudžiai, kad sujungtų praktinį ir teorinį mokymą. Mokymosi institucijos suteikia galimybę mokytis, plėsti žinias, taip pat lavinti loginį ir krintinį mąstymą, problemų sprendimo, komunikacijos bei prisitaikymo įgudžius gamtos mokslų, technologijų, inžinerijos, menų bei matematikos srityse.') }}</h2>
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

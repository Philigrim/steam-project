@extends('layouts.app')

@section('content')
<div class="header pb-5 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url(../argon/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
                <h1 class="display-2 text-white">Naujienų redagavimas</h1>
                <p class="text-white mt-0 mb-5">Šiame puslapyje galite redaguoti pasirinktą naujieną.</p>
            </div>
        </div>
    </div>
</div> 


    <!-- Announcemenet -->

    <div class="column d-flex justify-content-center">

        @foreach ($announcement as $announcement)

        <div class="card card-stats mt-3" style="width: 55rem">
            <div class="card-body border border-primary rounded">
                    
                <div class="column">

                <form action="{{ url('/announcements', [$announcement->announcement_id]) }}" method="post">
                    <input type="hidden" name="_method" value="patch" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                <input type="hidden" name="announcement_id" value="{{ $announcement->announcement_id }}">
                <div class="row border-top mt-2 mb-2"></div>

                <div class="row d-flex justify-content-center">
                    <input class="col-md-5 form-control" name="announcement_title" value="{{ $announcement->announcement_title }}" required
                    oninvalid="this.setCustomValidity('Pranešimo autoriaus langelis negali būti tuščias.')">
                </div>

                <div class="border-top mt-2 mb-2"></div>

                <div class="row">
                    <div class="col ml-2">
                        <div class="row">
                            Autorius:
                            <input class="col-md-5 ml-2 form-control" name="announcement_author" value="{{ $announcement->announcement_author}}" required
                            oninvalid="this.setCustomValidity('Pranešimo autoriaus langelis negali būti tuščias.')">
                        </div>
                    </div>

                    <div class="col">
                        <div class="float-right">
                            {{ $announcement->created_at}}
                        </div>
                    </div>
                </div>
                    
                <div class="border-top mt-2 mb-2"></div>

                <textarea class="form-control" rows="15" placeholder="Įveskite pranešimą kitiems vartotojams" name="announcement_text" required
                oninvalid="this.setCustomValidity('Pranešimo langelis negali būti tuščias.')">{{ $announcement->announcement_text}}</textarea>

                <div class="border-top mt-2 mb-2"></div>

                <div class = "float-right">
                    <a href="/home">
                        <button type = "button" class = "btn btn-danger">
                        Atsaukti
                        </button>
                    </a>
                    <button type = "submit" class = "btn btn-success">
                        Pataisyti naujiena
                    </button>
                </div>

                </form> 
                </div>

            </div>
        </div>
        @endforeach
    </div>
    <!-- /Announcement -->
@include('layouts.footers.auth')

@endsection

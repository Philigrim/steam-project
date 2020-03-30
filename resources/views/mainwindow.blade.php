@extends('layouts.app')

@section('content')
<div class="header pb-5 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url(../argon/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
                <h1 class="display-2 text-white">Naujienos</h1>
                <p class="text-white mt-0 mb-5">Siame puslapyje skelbiama informacija apie STEAM centrus bei kitos naujienos.</p>
                            
                <!-- Button trigger modal -->
                <button class = "btn btn-success" data-toggle = "modal" data-target = "#createAnnouncementModal">
                    Prideti nauja pranesima
                </button>
            </div>
        </div>
    </div>
</div> 

    <!-- Announcemenet Creation Modal -->

<div class = "modal fade" id = "createAnnouncementModal" tabindex = "-1" role = "dialog" aria-labelledby = "createAnnouncementLabel" aria-hidden = "true">
    
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            
            <div class = "modal-header">
                <h2 class = "modal-title" id = "createAnnouncementLabel">
                    Naujo pranesimo kurimas
                </h2>

                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>
            </div>

            <form action = "/home" method="post">
            @csrf

            <div class = "modal-body">
                <label>Autorius:</label>
                <input class="form-control" name="announcement_author" value="{{ auth()->user()->firstname}} {{auth()->user()->lastname}}" required
                oninvalid="this.setCustomValidity('Iveskite pranesimo pavadinima.')">

                <label class="mt-3">Pranesimo pavadinimas:</label>
                <input class="form-control" placeholder="Pavadinimas" name="announcement_title" required
                oninvalid="this.setCustomValidity('Iveskite pranesimo pavadinima.')">

                <label class="mt-3">Pranesimas:</label>
                <textarea class="form-control" rows="5" placeholder="Iveskite pranesima kitiems vartotojams" name="announcement_text" required
                oninvalid="this.setCustomValidity('Pranesimo langelis negali buti tuscias.')"></textarea>
            </div>

            <div class = "modal-footer">
                <button type = "button" class = "btn btn-danger" data-dismiss = "modal">
                    Atsaukti
                </button>
                
                <button type = "submit" class = "btn btn-success">
                    Paskelbti naujiena
                </button>

            </div>
            
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    
</div>
    <!-- /.modal -->
    

    <!-- Announcemenet Editing Modal -->

<div class = "modal fade" id = "editAnnouncementModal" tabindex = "-1" role = "dialog" aria-labelledby = "editAnnouncementLabel" aria-hidden = "true">
    
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            
            <div class = "modal-header">
                <h2 class = "modal-title" id = "editAnnouncementLabel">
                    Pranesimo redagavimas
                </h2>

                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>
            </div>

        <form action = "/home/edit" method="post">
                @method('put')
                @csrf
    
            <div class = "modal-body">
                <label class="mt-3">Id: </label>
                <input class="form-control" name="announcement_id" value="{{  auth()->user()->firstname }} {{auth()->user()->lastname}}" required
                oninvalid="this.setCustomValidity('Iveskite pranesimo pavadinima.')">

                <label class="mt-3">Autorius:</label>
                <input class="form-control" name="announcement_author" value="{{ auth()->user()->firstname }} {{auth()->user()->lastname}}" required
                oninvalid="this.setCustomValidity('Iveskite pranesimo pavadinima.')">

                <label class="mt-3">Pranesimo pavadinimas:</label>
                <input class="form-control" placeholder="Pavadinimas" name="announcement_title" required
                oninvalid="this.setCustomValidity('Iveskite pranesimo pavadinima.')">

                <label class="mt-3">Pranesimas:</label>
                <textarea class="form-control" rows="5" placeholder="Iveskite pranesima kitiems vartotojams" name="announcement_text" required
                oninvalid="this.setCustomValidity('Pranesimo langelis negali buti tuscias.')"></textarea>
            </div>

            <div class = "modal-footer">
                <button type = "button" class = "btn btn-danger" data-dismiss = "modal">
                    Atsaukti
                </button>
                
                <button type = "submit" class = "btn btn-success">
                    Pataisyti naujiena
                </button>

            </div>
            
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    
</div>
    <!-- /.modal -->

@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">


    <!-- Announcemenets -->

    <div class="column">

        @foreach ($announcements as $announcement)

        <div class="card card-stats ml-5 mt-3" style="width: 55rem">
            <div class="card-body border border-primary rounded">
                    
                <div class="row d-flex float-right">
                    
                <form action="{{ url('/announcements/edit', [$announcement->announcement_id]) }}" method="post">
                    <input class="btn btn-success ml-3" type="submit" value="Redaguoti" />
                    <input type="hidden" name="_method" value="put" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form> 

                <form action="{{ url('/announcements/delete', [$announcement->announcement_id]) }}" method="post">
                    <input class="btn btn-danger ml-3" type="submit" value="Istrinti" />
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form> 
                </div>

                <br>
                <br>

                <div class="row border-top mt-2 mb-2"></div>

                <div class="row d-flex justify-content-center">
                    <h1 class="card-title font-weight-bold">{{ $announcement->announcement_title }}</h1>
                </div>

                <div class="border-top mt-2 mb-2"></div>

                <div>
                <span class="ml-2">Autorius:</span>
                <span class="ml-2">{{ $announcement->announcement_author}}</span>
                <div class="ml-2 float-right"> {{ $announcement->created_at}} </div>
                </div>

                <div class="border-top mt-2 mb-2"></div>

                <div class="ml-2">{{ $announcement->announcement_text}}</div>

                <div class="border-top mt-2 mb-2"></div>
                
            </div>
        </div>
        @endforeach
    </div>
    <!-- /Announcements -->

    <!-- Promoted Courses (right side)-->
    <span class="mt-10 ml-6" style="width: 50rem; float:right;">
        <div class="card card-stats mt-3 ml-9">
            <div class="card-body border border-primary rounded">
                
                <h1 class="card-title font-weight-bold d-flex justify-content-center"> TEST Promoted course title #1 </h1>
                
                <div class="border-top mt-2 mb-2"></div>

                <div class="ml-2"> TEST Promoted course text/info1 </div>

                

                <div class="border-top mt-2 mb-2"></div>
                <span class="ml-2">Lecturer:</span>
                <span class="ml-2"> TEST TEST </span>
                <button type = "submit" class = "btn btn-success float-right">
                JOIN
                </button>
                </a>   
            </div>
        </div>

        <div class="card card-stats mt-3 ml-9">
            <div class="card-body border border-primary rounded">
                
                <h1 class="card-title font-weight-bold d-flex justify-content-center"> TEST Promoted course title #2 </h1>
                
                <div class="border-top mt-2 mb-2"></div>

                <div class="ml-2"> TEST Promoted course text/info </div>

                

                <div class="border-top mt-2 mb-2"></div>
                <span class="ml-2">Lecturer:</span>
                <span class="ml-2"> TEST TEST </span>
                <button type = "submit" class = "btn btn-success float-right">
                JOIN
                </button>
                </a>   
            </div>
        </div>

        <div class="card card-stats mt-3 ml-9">
            <div class="card-body border border-primary rounded">
                
                <h1 class="card-title font-weight-bold d-flex justify-content-center"> TEST Promoted course title #3 </h1>
                
                <div class="border-top mt-2 mb-2"></div>

                <div class="ml-2"> TEST Promoted course text/info </div>

                

                <div class="border-top mt-2 mb-2"></div>
                <span class="ml-2">Lecturer:</span>
                <span class="ml-2"> TEST TEST </span>
                <button type = "submit" class = "btn btn-success float-right">
                JOIN
                </button>
                </a>   
            </div>
        </div>
    </span>
    <!-- /Promoted Courses (right side) -->

</div>

@include('layouts.footers.auth')

@endsection

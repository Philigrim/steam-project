<div class="header pb-5 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url(../argon/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
                <h1 class="display-2 text-white">{{ $title }}</h1>
                @if (isset($description) && $description)
                    <p class="text-white mt-0 mb-5">{{ $description }}</p>
                @endif

                @if (isset($title))
                @if (($title == __('Naujienos')) && (Auth::user()->isRole()=="admin"))
                <!-- Button trigger Announcement Creation modal -->
                <button class = "btn btn-success" data-toggle = "modal" data-target = "#createAnnouncementModal">
                    Prideti naują pranešimą
                </button>

                @elseif ($title == __('Dažniausiai užduodami klausimai'))
                <!-- Button trigger Question Asking modal -->
                <button class = "btn btn-success" data-toggle = "modal" data-target = "#askQuestionModal">
                    Pateikti naują klausimą
                </button>

                @if (Auth::user()->isRole()=="admin")
                <!-- Button trigger Question Answering modal -->
                <button class = "btn btn-success" data-toggle = "modal" data-target = "#answerQuestionModal">
                    Atsakyti į klausimą
                </button>
                @endif
                @endif
                @endif
            </div>
        </div>
    </div>
</div>


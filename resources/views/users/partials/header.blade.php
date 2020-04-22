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
                <!-- Button trigger modal -->
                <button class = "btn btn-success" data-toggle = "modal" data-target = "#createAnnouncementModal">
                    Prideti naują pranešimą
                </button>
                <!-- Announcemenet Creation Modal -->
                <div class = "modal fade" id = "createAnnouncementModal" tabindex = "-1" role = "dialog" aria-labelledby = "createAnnouncementLabel" aria-hidden = "true">

                    <div class = "modal-dialog modal-lg">
                        <div class = "modal-content">

                            <div class = "modal-header">
                                <h2 class = "modal-title" id = "createAnnouncementLabel">
                                    Naujo pranešimo kūrimas
                                </h2>

                                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                                    &times;
                                </button>
                            </div>
                            <form action = {{ route('announcements.store')}} method="post">
                            @csrf

                            <div class = "modal-body">
                                <label>Autorius:</label>
                                <input class="form-control" placeholder="Įveskite pranešimo autorių" name="announcement_author" value="{{ auth()->user()->firstname}} {{auth()->user()->lastname}}" required
                                oninvalid="this.setCustomValidity('Pranešimo autoriaus langelis negali būti tuščias.')">

                                <label class="mt-3">Pranešimo pavadinimas:</label>
                                <input class="form-control" placeholder="Įveskite pranešimo pavadinimą" name="announcement_title" required
                                oninvalid="this.setCustomValidity('Pranešimo pavadinimo langelis  negali būti tuščias.')">

                                <label class="mt-3">Pranešimas:</label>
                                <textarea class="form-control" rows="5" placeholder="Įveskite pranešimą kitiems vartotojams" name="announcement_text" required
                                oninvalid="this.setCustomValidity('Pranešimo langelis negali būti tuščias.')"></textarea>
                            </div>

                            <div class = "modal-footer">
                                <button type = "button" class = "btn btn-danger" data-dismiss = "modal">
                                    Atšaukti
                                </button>

                                <button type = "submit" class = "btn btn-success">
                                    Paskelbti naujieną
                                </button>

                            </div>

                            </form>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->

                </div>
                <!-- /.modal -->
                @endif

                @if ($title == __('Dažniausiai užduodami klausimai'))
                <!-- Button trigger Question Asking modal -->
                <button class = "btn btn-success" data-toggle = "modal" data-target = "#askQuestionModal">
                    Pateikti naują klausimą
                </button>
                <!-- Question Asking Modal -->
                <div class = "modal fade" id = "askQuestionModal" tabindex = "-1" role = "dialog" aria-labelledby = "askQuestionLabel" aria-hidden = "true">

                    <div class = "modal-dialog modal-lg mt-9">
                        <div class = "modal-content">

                            <div class = "modal-header">
                                <h2 class = "modal-title" id = "askQuestionLabel">
                                    Naujo klausimo kūrimas
                                </h2>
                                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                                    &times;
                                </button>
                            </div>

                            <form action="{{ route('faq.store.question') }}" method="post">
                            @csrf

                            <div class = "modal-body">
                                <p>Neradote atsakymo į rūpimą klausimą? Pateikite jį žemiau ir mes pasistengsime atsakyti!</p>
                                <br>
                                <label class="mt-2">Klausimas:</label>
                                <textarea class="form-control" rows="3" placeholder="Įveskite norimą klausimą" name="question" required
                                oninvalid="this.setCustomValidity('Klausimo langelis negali būti tuščias.')"></textarea>
                            </div>

                            <div class = "modal-footer">
                                <button type = "button" class = "btn btn-danger" data-dismiss = "modal">
                                    Atšaukti
                                </button>

                                <button type = "submit" class = "btn btn-success">
                                    Pateikti klausimą
                                </button>

                            </div>

                            </form>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->

                </div>
                <!-- /.modal -->

                @if (Auth::user()->isRole()=="admin")
                <!-- Button trigger Question Answering modal -->
                <button class = "btn btn-success" data-toggle = "modal" data-target = "#answerQuestionModal">
                    Atsakyti į klausimą
                </button>
                <!-- Question Answering Modal -->
                <div class = "modal fade" id = "answerQuestionModal" tabindex = "-1" role = "dialog" aria-labelledby = "answerQuestionLabel" aria-hidden = "true">

                    <div class = "modal-dialog modal-lg mt-9">
                        <div class = "modal-content">

                            <div class = "modal-header">
                                <h2 class = "modal-title" id = "answerQuestionLabel">
                                    Atsakymo į klausimą pateikimas
                                </h2>
                                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                                    &times;
                                </button>
                            </div>

                            <form action="{{ route('faq.store.answer') }}" method="post">
                            <input type="hidden" name="_method" value="patch" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class = "modal-body">
                                <label class="mt-2">Klausimas:</label>

                                <br>

                                <div class="row">

                                    <div class="col">
                                        <select class="form-control" name="question">
                                        @foreach ($questions as $question)
                                        <option id="{{ $question->faq_id }}" value="{{ $question->question }}">{{ $question->question }}</option>
                                        @endforeach
                                        </select>
                                    </div>

                                </div>


                                <label class="mt-2">Atsakymas:</label>
                                <textarea class="form-control" rows="3" placeholder="Atsakykite į pasirinktą klausimą" name="answer" required
                                oninvalid="this.setCustomValidity('Klausimo langelis negali būti tuščias.')"></textarea>
                            </div>

                            <div class = "modal-footer">

                                <button type = "button" class = "btn btn-danger" data-dismiss = "modal">
                                    Atšaukti
                                </button>

                                <button type = "submit" class = "btn btn-success">
                                    Pateikti klausimą
                                </button>

                            </div>

                            </form>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->

                </div>
                <!-- /.modal -->
                @endif
                @endif
                @endif
            </div>
        </div>
    </div>
</div>


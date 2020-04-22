<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('announcements') }}">
            <img src="{{ asset('argon') }}/img/brand/steam1.jpeg" class="navbar-brand-img" alt = "...">
            <img src="{{ asset('argon') }}/img/brand/steam2.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Mano paskyra') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Nustatymai') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('announcements') }}">
                            <img src="{{ asset('argon') }}/img/brand/steam1.jpeg">
                            <img src="{{ asset('argon') }}/img/brand/steam.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('announcements') }}">
                                    {{ __('Naujienos') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('Kursai') }}">
                                    {{ __('Kursai') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('Paskaitos') }}">
                                    {{ __('Paskaitos') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('faq') }}">
                                    {{ __('D.U.K.') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('about') }}">
                                    {{ __('Apie') }}
                                </a>
                            </li>
                            @if(Auth::user()->isRole()=="paskaitu_lektorius")
                            <!-- Divider -->
                            <li><hr class="my-0"></li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('RouteToCreateEvent') }}">
                                    {{ __('Sukurti paskaitą') }}
                                </a>
                            </li>
                            <!-- Divider -->
                            <li><hr class="my-0"></li>
                            @endif
                            @if(Auth::user()->isRole()=="admin")
                            <!-- Divider -->
                            <li><hr class="my-0"></li>
                            <!-- Other functions -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media align-items-center">{{ __('Kitos funkcijos') }}</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-arrow" style="width:100%">
                                    <a href="{{ route('RouteToCreateCourse') }}" class="dropdown-item">
                                        {{ __('Sukurti kursą') }}
                                    </a>
                                    <a href="{{ route('RouteToCreateEvent') }}" class="dropdown-item">
                                        {{ __('Sukurti paskaitą') }}
                                    </a>
                                    <a href="{{ route('RouteToUserManagement') }}" class="dropdown-item">
                                        {{ __('Vartotojų valdymas') }}
                                    </a>
                                    <a href="{{ route('iterpimas') }}" class="dropdown-item">
                                        {{ __('Duomenų įterpimas') }}
                                    </a>
                                </div>
                            </li>
                            <!-- Divider -->
                            <li><hr class="my-0"></li>
                            @endif
                        </ul>
                    </div>

            </ul>


            <!-- Search & Filters -->
            @if (isset($title) && $title == __('Paskaitos'))

            <!-- Search form -->
            <form action="{{ route('events.search') }}" method="get">
                <div class="input-group mt-3">
                    <input class="form-control" name="search" type="text" @if (isset($search_value)) value="{{ $search_value }}" @endif placeholder="Raskite paskaitą">
                    <div class="input-group-append">
                    <button class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form> 


            <!-- Filters -->
            <form action="{{ route('events.filter')}} " method="get">

            {{ __('Kategorija:') }}
            <select class="mdb-select md-form mb-2" style="width:100%;" name="filterCategoryInput">
                <option selected disabled>{{ "Pasirinkite kategoriją" }}</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->subject }}">{{ $subject->subject }}</option>
                @endforeach
            </select>

            <br>

            {{ __('Laisvų vietų skaičius:') }}
            <input class="mb-2" style="width:100%;" type="number" name="filterCapacityInput" placeholder="Nesvarbus" min="1">

            {{ __('Miestas:') }}
            <select class="mdb-select md-form mb-2"  style="width:100%;" name="filterCityInput">
                <option selected disabled>{{ "Nurodykite miestą" }}</option>
                @foreach($cities as $city)
                <option value="{{ $city->city_name }}">{{ $city->city_name }}</option>
                @endforeach
            </select>

            {{ __('Data:') }}
            <select class="mdb-select md-form mb-2" style="width:100%;" onchange="showHide(this)">
                <option disabled selected>Įvesties tipas</option>
                <option value="oneDay">Diena</option>
                <option value="interval">Intervalas</option>
            </select>

            <div id="dateFilters">

            <div class="form-group mb-2" style="width:100%; display:none;">
                <input placeholder="Pasirinkite datą" id="dateFrom" name="filterDateFrom"/>
            </div>
            <div class="form-group mb-2" style="width:100%; display:none;">
                <input placeholder="Pasirinkite datą" id="dateTo" name="filterDateTo"/>
            </div>

            </div>

            <row class="d-flex justify-content-center">
                <button type = "submit" class = "btn btn-success">
                    Rodyti rezultatus
                </button>
            </row>

            </form>

            @endif

            <!-- /Filters -->

                        <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">

            </ul>
        </div>
    </div>
</nav>
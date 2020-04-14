<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
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
                        <a href="{{ route('home') }}">
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="text-primary"></i> {{ __('Naujienos') }}
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Laravel Examples') }}</span>
                    </a> --}}

                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('Kursai') }}">
                                    {{ __('Kursai') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.edit') }}">
                                    {{ __('Vartotojo paskyra') }}
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
                            @if(Auth::user()->isRole()=="admin")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('RouteToCreateCourse') }}">
                                    {{ __('Sukurti kursą') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('RouteToUserManagement') }}">
                                    {{ __('Vartotojų valdymas') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('iterpimas') }}">
                                    {{ __('Duomenų įterpimas') }}
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>

            </ul>

            <!-- Divider -->
            <hr class="my-3">

            @if (isset($title) && $title == __('Paskaitos'))

            <!-- Filters -->
            
            <p class="d-flex justify-content-center" style="font-size:150%;">Filtrai</p>

            <!-- Divider -->
            <hr class="my-2">

            <div>

            <form action="{{ route('events.filter')}} " method="get">

            Kategorija:
            <select class="mdb-select md-form mb-2" style="width:100%;" name="filterCategoryInput">
                <option disabled selected>Pasirinkite kategorija</option>
                <option value="Science">Science</option>
                <option value="Technologijos">Technologijos</option>
                <option value="Engineering">Engineering</option>
                <option value="Arts">Arts</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Biology">Biologija</option>
                <option value="Engineering">Inžinerija</option>
                <option value="Informatics">Informatika</option>
                <option value="Chemistry">Chemija</option>
            </select>

            Laisvų vietų skaičius:
            <input class="mb-2" style="width:100%;" type="number" name="filterCapacityInput" placeholder="Nesvarbus" min="1">

            Miestas:
            <select class="mdb-select md-form mb-2"  style="width:100%;" name="filterCityInput">
                <option disabled selected>Nurodykite miestą</option>
                <option value="vilnius">Vilnius</option>
                <option value="kaunas">Kaunas</option>
                <option value="klaipėda">Klaipėda</option>
                <option disabled="disabled">-------------------------------</option>
                <option value="alytus">Alytus</option>
                <option value="marijapmolė">Marijapmolė</option>
                <option value="panevėžys">Panevėžys</option>
                <option value="Šiauliai">Šiauliai</option>
                <option value="tauragė">Tauragė</option>
                <option value="telšiai">Telšiai</option>
                <option value="utena">Utena</option>
            </select>

            <row class="d-flex justify-content-center mt-1">
                <button type = "submit" class = "btn btn-success">
                    Rodyti rezultatus
                </button>
            </row>


            </form>

            </div>
            <!-- Divider -->
            <hr class="my-3">
            @endif

            <!-- /Filters -->

                        <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">

            </ul>
        </div>
    </div>
</nav>

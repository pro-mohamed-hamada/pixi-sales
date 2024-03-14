<nav class="navbar navbar-expand-md shadow-sm navbar-default fixed-top col-md-9 col-xs-10 col-lg-10 offset-xs-2 offset-md-3 offset-lg-2">
            <div class="container-fluid">
                
                <div class="navbar-brand">
                    <i class="sideBar-button navbar-brand fa fa-align-left d-md-none"></i>
                    <a  class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- start language --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-language"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('lang', 'en' )}}">
                                       {{ __('lang.english') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('lang', 'ar' )}}">
                                       {{ __('lang.arabic') }}
                                    </a>

                                </div>
                            </li>
                            {{-- end language --}}

                            {{-- start notification --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-bell-o"></i>
                                    
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('lang', 'en' )}}">
                                       {{ __('lang.english') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('lang', 'ar' )}}">
                                       {{ __('lang.arabic') }}
                                    </a>

                                </div>
                            </li>
                            {{-- end notification --}}

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img style="width:20px" class=" img-responsive img-circle img-thumbnail" src="{{ empty(Auth::user()->getFirstMediaUrl('users')) ? asset('images/default-image.jpg'):Auth::user()->getFirstMediaUrl('users')}}">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.view') }}">
                                        {{ __('lang.profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('lang.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

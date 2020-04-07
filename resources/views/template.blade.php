<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="An exclusive and secretive World of Warcraft Classic raiding guild on Pyrewood Village.">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="x-ga-property" content="UA-23790873-11">
        @if ($user)
            <meta name="x-user-id" content="{{ $user->id }}">
        @endif

        <title>@yield('title')</title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link rel="icon" sizes="192x192" href="{{ asset('images/app_icon_192.png') }}">
    </head>
    <body class="bg-brown-texture">
        <nav class="navbar navbar-expand-lg navbar-dark" id="navbar">
            <a class="navbar-brand" href="{{ route('homepage') }}">
                <font-awesome-icon :icon="['fas', 'home']" class="home-icon"></font-awesome-icon>
                The Order
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @include('navigation')
                </ul>
                <ul class="navbar-nav">
                    @if ($user)
                        {{-- <notifications-menu-item></notifications-menu-item> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $user->nickname }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right bg-brown" aria-labelledby="authDropdown">
                                <a class="dropdown-item nav-link" href="{{ url('account/settings') }}">Account Settings</a>
                                @can('access-officers-control-panel')
                                    <a class="dropdown-item nav-link" href="{{ route('control_panel.index') }}">Officers' Control Panel</a>
                                @endcan
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item nav-link" href="{{ url('logout') }}">Logout</a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-navigation my-2 my-sm-0" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
            @section('content')
                <div id="app"></div>
            @show
        </div>

        @include('footer')

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

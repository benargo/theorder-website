<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ __('meta.description') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="x-ga-property" content="UA-23790873-11">
        @if ($user)
            <meta name="x-user-id" content="{{ $user->id }}">
        @endif

        <title>@yield('title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="icon" sizes="192x192" href="{{ asset('images/app_icon_192.png') }}">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark" id="navbar">
            <a class="navbar-brand" href="{{ url('/') }}">
                <font-awesome-icon :icon="['fas', 'home']" class="home-icon"></font-awesome-icon>
                {{ __('meta.title') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('roster') }}">
                            <font-awesome-icon :icon="['far', 'address-book']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.roster') }}
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('news') }}">
                            <font-awesome-icon :icon="['far', 'newspaper']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.news') }}
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('forum') }}">
                            <font-awesome-icon :icon="['far', 'comments']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.forum') }}
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('events') }}">
                            <font-awesome-icon :icon="['far', 'calendar-alt']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.events') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('teams') }}">
                            <font-awesome-icon :icon="['far', 'helmet-battle']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.teams') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('marketplace') }}">
                            <font-awesome-icon :icon="['far', 'balance-scale']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.marketplace') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('discord') }}">
                            <font-awesome-icon :icon="['fab', 'discord']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.discord') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('join') }}">
                            <font-awesome-icon :icon="['far', 'user-plus']" class="nav-icon"></font-awesome-icon>
                            {{ __('navigation.join') }}
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @if ($user)
                        <notifications-menu-item
                            :lang="{
                                notifications: '{{ __('navigation.notifications') }}',
                                notifications_history: '{{ __('navigation.notifications_history') }}'
                            }"
                            :number-unread="3"
                        ></notifications-menu-item>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ str_before($user->battletag, '#') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right bg-brown" aria-labelledby="authDropdown">
                                <a class="dropdown-item nav-link" href="{{ url('account/settings') }}">{{ __('navigation.account_settings') }}</a>
                                {{-- <a class="dropdown-item nav-link" href="{{ url('account/character-select') }}">{{ __('navigation.character_select') }}</a> --}}
                                @if ($user->rank->seniority <= 1)
                                    <a class="dropdown-item nav-link" href="{{ url('officers') }}">{{ __('navigation.officers_control_panel') }}</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item nav-link" href="{{ url('logout') }}">{{ __('navigation.logout') }}</a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-outline-secondary" href="{{ route('login.auth') }}">{{ __('navigation.login') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
            @section('content')
                <div id="app"></div>
            @show
        </div>

        <footer class="footer bg-brown-texture">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <ul class="nav">
                            <li class="nav-item copyright" rel="copyright">
                                {!! __('footer.copyright', ['year' => date('Y')]) !!}
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('your-data') }}">
                                    {{ __('footer.privacy') }}
                                </a>
                            </li>
					        <li class="nav-item">
                                <a class="nav-link" href="{{ url('battlenet') }}">
                                    {{ __('footer.battlenet') }}
                                </a>
                            </li>
                        </ul>
                        <p class="disclaimer">
                            <strong>{{ __('footer.disclaimer.title') }}</strong>
                            {!! __('footer.disclaimer.body') !!}
                        </p>
                    </div>
                    <div class="col-12 col-md-2 cmtcloud-column text-center">
                        <a class="cmtcloud-link" href="http://cmtcloud.uk" target="_blank">
                            <img class="cmtcloud-logo" src="{{ asset('images/cmtcloud_logo.svg') }}" alt="CMT Cloud Services logo" height="39" />
                            <p>{!! __('footer.promotion') !!}</p>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

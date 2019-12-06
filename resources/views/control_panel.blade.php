@extends('template')

@section('title', 'Inner Circle Control Panel')

@section('content')
    <div id="app" class="page-control-panel-index">
        <div class="container-fluid bg-engineering py-7 text-light">
            <div class="content">
                <h1 class="text-center">
                    Inner Circle
                    <br class="d-md-none">
                    Control Panel
                </h1>
            </div>
        </div>
        <div class="bg-brown-texture py-6 text-light">
            <div class="container">

                {{-- Roster --}}
                <h2>Roster</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/members') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                        Manage members
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/ranks') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users-crown']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Manage guild ranks
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Recruitment --}}
                <h2 class="mt-4">Recruitment</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/applications?status=pending') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'user-plus']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    View new applicants
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/applications') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'user-clock']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    View all applicants
                                </div>
                            </div>
                        </a>
                    </div>
                    {{-- TODO: Add route to load to Statistics tab --}}
                    {{-- <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/applications/statistics') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'chart-line']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    View statistics
                                </div>
                            </div>
                        </a>
                    </div> --}}
                </div>

                {{-- News --}}
                <h2 class="mt-4">News</h2>
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="alert alert-info" role="alert">
                            The News feature has been deprecated. Please publish all announcements on <a href="{{ route('discord-channel', ['channel' => 479666941447897109]) }}" title="#announcements on Discord">Discord</a> instead.
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/news/create') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'pen-fancy']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Create a news item
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/news') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'pencil']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Edit a news item
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Forum --}}
                {{-- <h2 class="mt-4">
                    Forum
                    <small class="text-muted">(not yet implemented)</small>
                </h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/forum') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'chalkboard']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Manage boards
                                </div>
                            </div>
                        </a>
                    </div>
                </div> --}}

                {{-- Events --}}
                <h2 class="mt-4">
                    Events
                    <small class="text-muted">(not yet implemented)</small>
                </h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/events/new') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'calendar-plus']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Create a new event
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/events?action=edit') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'calendar-edit']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Edit an event
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/events?action=remind') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'bell']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Send a reminder to attendees
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Teams --}}
                <h2 class="mt-4">
                    Teams
                    <small class="text-muted">(not yet implemented)</small>
                </h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/teams/new') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Create a new team
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/teams?action=edit') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users-cog']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Manage a team
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/teams?action=message') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'paper-plane']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Message a team
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Guild Bank --}}
                <h2 class="mt-4">Guild bank</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/guild-bank/clients') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'cogs']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Stock Addon Settings
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/guild-bank/bankers') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'user-lock']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Manage bank characters
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Marketplace --}}
                <h2 class="mt-4">Marketplace</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/marketplace/transactions') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'clipboard-list']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Review transactions
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/marketplace/stats') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'chart-line']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    View stats
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

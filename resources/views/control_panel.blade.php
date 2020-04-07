@extends('template')

@section('title', 'Officers’ Control Panel')

@section('content')
    <div id="app" class="page-control-panel-index">
        <div class="container-fluid bg-engineering py-7 text-light">
            <div class="content">
                <h1 class="text-center">
                    Officers&rsquo;
                    <br class="d-md-none">
                    Control Panel
                </h1>
            </div>
        </div>
        <div class="py-6 text-light">
            <div class="container">

                {{-- Roster --}}
                <h2>Roster &amp; Ranks</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ route('control_panel.manage_ranks') }}" class="d-block border border-primary rounded my-2 py-4">
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
                </div>

                {{-- News --}}
                <h2 class="mt-4">News</h2>
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

                {{-- Guild Bank --}}
                <h2 class="mt-4">Guild bank</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/guild-bank/bankers') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'user-lock']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Set bank characters
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- API Settings --}}
                <h2 class="mt-4">API Settings</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning my-1" role="alert">
                            These settings are intended for developers only. It's recommended that you do not touch this zone unless you are an experienced user.
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/guild-bank/clients') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'cogs']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    Manage API Clients &amp; Secrets
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

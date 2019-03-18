@extends('template')

@section('title', __('controlpanel.control_panel'))

@section('content')
    <div id="app" class="page-control-panel-index">
        <div class="container-fluid bg-engineering extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">
                    {{ __('controlpanel.inner_circle') }}
                    <br class="d-block d-md-none">
                    {{ __('controlpanel.control_panel') }}
                </h1>
            </div>
        </div>
        <div class="bg-brown-texture extra-padding-top extra-padding-bottom text-light">
            <div class="container">
                <h2>{{ __('controlpanel.roster') }}</h2>
                <div class="row action-cards">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/ranks') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users-crown']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.manage_ranks') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <h2>{{ __('controlpanel.news') }}</h2>
                <div class="row action-cards">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/news/create') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'pen-fancy']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.create_news_item') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/news') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'pencil']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.edit_news_item') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <h2>{{ __('controlpanel.forum') }}</h2>
                <div class="row action-cards">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/forum') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'chalkboard']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.manage_forum_boards') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <h2>{{ __('controlpanel.events') }}</h2>
                <div class="row action-cards">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/events/new') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'calendar-plus']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.create_event') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/events?action=edit') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'calendar-edit']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.edit_event') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/events?action=remind') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'bell']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.send_event_reminder') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <h2>{{ __('controlpanel.teams') }}</h2>
                <div class="row action-cards">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/teams/new') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.create_team') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/teams?action=edit') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users-cog']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.edit_team') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/teams?action=message') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'paper-plane']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.message_team') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <h2>{{ __('controlpanel.marketplace') }}</h2>
                <div class="row action-cards">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/marketplace/transactions') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'clipboard-list']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.review_marketplace_transactions') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/marketplace/stats') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'chart-line']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.view_marketplace_statistics') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <h2>{{ __('controlpanel.applications') }}</h2>
                <div class="row action-cards">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/applications?status=pending') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'user-plus']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.view_new_applicants') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/applications') }}" class="card-action">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'user-clock']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.view_all_applicants') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('template')

@section('title', __('controlpanel.control_panel'))

@section('content')
    <div id="app" class="page-control-panel-index">
        <div class="container-fluid bg-engineering py-7 text-light">
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

                {{-- Roster --}}
                <h2>{{ __('controlpanel.roster') }}</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/members') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'users']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                        {{ __('controlpanel.manage_members') }}
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
                                    {{ __('controlpanel.manage_ranks') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- News --}}
                <h2 class="mt-4">{{ __('controlpanel.news') }}</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/news/create') }}" class="d-block border border-primary rounded my-2 py-4">
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
                        <a href="{{ url('inner-circle/news') }}" class="d-block border border-primary rounded my-2 py-4">
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

                {{-- Forum --}}
                {{-- <h2>{{ __('controlpanel.forum') }}</h2> --}}
                <h2 class="mt-4">
                    {{ __('controlpanel.forum') }}
                    <small class="text-muted">{{ __('controlpanel.not_yet_implemented') }}</small>
                </h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        {{-- <a href="{{ url('inner-circle/forum') }}" class="d-block border border-primary rounded my-2 py-4"> --}}
                        <a href="javascript:void();" class="d-block border border-primary rounded my-2 py-4 disabled" tabindex="-1" role="button" aria-disabled="true">
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

                {{-- Events --}}
                <h2 class="mt-4">{{ __('controlpanel.events') }}</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/events/new') }}" class="d-block border border-primary rounded my-2 py-4">
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
                        <a href="{{ url('inner-circle/events?action=edit') }}" class="d-block border border-primary rounded my-2 py-4">
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
                        <a href="{{ url('inner-circle/events?action=remind') }}" class="d-block border border-primary rounded my-2 py-4">
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

                {{-- Teams --}}
                <h2 class="mt-4">{{ __('controlpanel.teams') }}</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/teams/new') }}" class="d-block border border-primary rounded my-2 py-4">
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
                        <a href="{{ url('inner-circle/teams?action=edit') }}" class="d-block border border-primary rounded my-2 py-4">
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
                        <a href="{{ url('inner-circle/teams?action=message') }}" class="d-block border border-primary rounded my-2 py-4">
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

                {{-- Guild Bank --}}
                <h2 class="mt-4">{{ __('controlpanel.guild_bank') }}</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/guild-bank/clients') }}" class="d-block border border-primary rounded my-2 py-4">
                            <div class="row no-gutters">
                                <div class="col-4 text-center">
                                    <font-awesome-icon :icon="['fas', 'user-cog']" class="fa-3x"></font-awesome-icon>
                                </div>
                                <div class="col-8 text-center v-align-center">
                                    {{ __('controlpanel.stock_addon_settings') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Marketplace --}}
                <h2 class="mt-4">{{ __('controlpanel.marketplace') }}</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/marketplace/transactions') }}" class="d-block border border-primary rounded my-2 py-4">
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
                        <a href="{{ url('inner-circle/marketplace/stats') }}" class="d-block border border-primary rounded my-2 py-4">
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

                {{-- Applications --}}
                <h2 class="mt-4">{{ __('controlpanel.applications') }}</h2>
                <div class="row my-2">
                    <div class="col-12 col-lg-4">
                        <a href="{{ url('inner-circle/applications?status=pending') }}" class="d-block border border-primary rounded my-2 py-4">
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
                        <a href="{{ url('inner-circle/applications') }}" class="d-block border border-primary rounded my-2 py-4">
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

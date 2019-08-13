@extends('template')

@section('title', __('controlpanel.applications'))

@section('content')
    <div id="app">
        <header class="container-fluid bg-engineering py-6 text-light">
            <div class="content">
                <h1 class="text-center">{{ __('controlpanel.applications') }}</h1>
            </div>
        </header>
        <div class="py-6 text-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <p class="lead">{{ __('applications.manage_lead') }}</p>
                    </div>
                </div>
            </div>
            <applications-manager
                :classes="{
                    @foreach ($classes as $class)
                        {{ $class->id }}: {
                            'id': {{ $class->id }},
                            'name': '{{ ucfirst(trans_choice('warcraft/classes.' . strtolower($class->name), 1)) }}',
                        },
                    @endforeach
                }"

                :lang="{
                    alerts: {
                        info_applicant_count_zero: '{{ __('applications.alerts.applicant_count_zero') }}',
                        info_applicant_count_zero_filtered: '{{ __('applications.alerts.applicant_count_zero_filtered') }}',
                        info_no_actions_available: '{{ __('applications.errors.no_actions_available') }}',
                    },
                    buttons: {
                        accept: '{{ __('applications.labels.accept') }}',
                        decline: '{{ __('applications.labels.decline') }}',
                        next: '{{ __('pagination.next') }}',
                        previous: '{{ __('pagination.previous') }}',
                    },
                    roles: {
                        @foreach ($roles as $r)
                            {{ $r }}: '{{ __("applications.labels.{$r}") }}',
                        @endforeach
                    },
                    status: {
                        accepted: '{{ ucfirst(__('applications.status.accepted')) }}',
                        declined: '{{ ucfirst(__('applications.status.declined')) }}',
                        pending: '{{ ucfirst(__('applications.status.pending')) }}',
                        withdrawn: '{{ ucfirst(__('applications.status.withdrawn')) }}',
                    },
                    tableHeaders: {
                        characterName: '{{ __('applications.character_name') }}',
                        class: '{{ __('applications.class') }}',
                        race: '{{ __('applications.race') }}',
                        role: '{{ __('applications.role') }}',
                        status: '{{ __('applications.labels.status') }}',
                        actions: '{{ __('applications.labels.actions') }}',
                    },
                    at:      '{{ __('applications.at') }}',
                    filters: '{{ __('applications.filters') }}',
                    on:      '{{ __('applications.on') }}',
                    since:   '{{ __('applications.since') }}',

                }"

                :races="{
                    @foreach ($races as $race)
                        {{ $race->id }}: {
                            'id': {{ $race->id }},
                            'name': '{{ trans_choice('warcraft/races.' . strtolower(snake_case($race->name)), 1) }}',
                        },
                    @endforeach
                }"

                :starting-filters="{
                    characterName: {!! isset($characterName) ? "'{$characterName}'" : 'undefined' !!},
                    classId:       {!! isset($classId) ? "'{$classId}'" : 'undefined' !!},
                    raceId:        {!! isset($raceId) ? "'{$raceId}'" : 'undefined' !!},
                    role:          {!! isset($role) ? "'{$role}'" : 'undefined' !!},
                    status:        {!! isset($status) ? "'{$status}'" : 'undefined' !!},
                }"
            ></applications-manager>
        </div>
    </div>
@endsection

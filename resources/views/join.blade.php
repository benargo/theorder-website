@extends('template')

@section('title', __('applications.join_title'))

@section('content')
    <div id="app">
        <header class="container-fluid bg-ironforge extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">{{ __('applications.join_title') }}</h1>
            </div>
        </header>
        <div class="container extra-padding-top extra-padding-bottom text-light">
            <p class="lead">{{ __('applications.lead') }}</p>
            <join-form
                :classes="{{ $classes->toJson() }}"
                discord-url="{{ action('DiscordController@redirectToServer', ['channel' => 552893734266863617]) }}"
                :races="{{ $races->toJson() }}"
                :lang="{
                    alerts: {
                        applicationAccepted: '{{ __('applications.alerts.application_accepted') }}',
                        applicationDeclined: '{{ __('applications.alerts.application_declined', ['date' => $application ? $application->canApplyAgainWhen()->format('n F Y') : '{date}']) }}',
                        applicationPending: '{!! __('applications.alerts.application_pending') !!}',
                        applicationSubmitted: '{{ __('applications.alerts.application_submitted') }}',
                    },
                    errors: {
                        characterNameInvalid: '{{ __('applications.errors.character_name_invalid') }}',
                        noClassSelected: '{{ __('applications.errors.no_class_selected') }}',
                        noRaceSelected: '{{ __('applications.errors.no_race_selected') }}',
                        noRoleSelected: '{{ __('applications.errors.no_role_selected') }}',
                    },
                    characterName: '{{ __('applications.character_name') }}',
                    class: '{{ __('applications.class') }}',
                    damage: '{{ __('applications.labels.damage') }}',
                    healer: '{{ __('applications.labels.healer') }}',
                    nextSteps: '{!! __('applications.next_steps') !!}',
                    race: '{{ __('applications.race') }}',
                    role: '{{ __('applications.role') }}',
                    submitApplication: '{{ __('applications.labels.submit_application') }}',
                    tank: '{{ __('applications.labels.tank') }}',
                }"
                @isset ($application)
                    status="{{ $application->getStatus() }}"
                @endisset
            ></join-form>
        </div>
    </div>
@endsection

@extends('template')

@section('title', __('account.my_account'))

@section('content')
    <div id="app">
        <header class="container-fluid bg-tavern extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">{{ __('account.my_account') }}</h1>
            </div>
        </header>
        <div class="container extra-padding-top extra-padding-bottom text-light">
            <p class="lead">{{ __('account.introduction_account_settings') }}</p>
            <account-settings
                :default-values="{
                    nickname: '{{ $nickname }}',
                    email: '{{ $email }}',
                    battletag: '{{ $battletag }}',
                    discordTag: '{{ $discord }}',
                }"
                :lang="{
                    buttons: {
                        unlink: '{{ __('account.buttons.unlink') }}',
                    },
                    forms: {
                        emailHelpBlock: '{{ __('account.email_help_block') }}',
                        looksGood: '{{ __('forms.looks_good') }}',
                        nicknameHelpBlock: '{{ __('account.nickname_help_block') }}',
                    },
                    labels: {
                        nickname: '{{ __('account.labels.nickname') }}',
                        email: '{{ __('account.labels.email') }}',
                        battletag: '{{ __('account.labels.battletag') }}',
                        discord: '{{ __('account.labels.discord') }}',
                    },
                }"
                :user-id="{{ $user->id }}"
            ></account-settings>
            <account-applications
                :classes="{{ $classes }}"
                :lang="{
                    applications: '{{ __('account.applications') }}',
                    on: '{{ __('applications.on') }}',
                    labels: {
                        characterName: '{{ __('applications.character_name') }}',
                        class: '{{ __('applications.class') }}',
                        damage: '{{ __('applications.labels.damage') }}',
                        healer: '{{ __('applications.labels.healer') }}',
                        race: '{{ __('applications.race') }}',
                        role: '{{ __('applications.role') }}',
                        status: '{{ __('applications.labels.status') }}',
                        tank: '{{ __('applications.labels.tank') }}',
                        withdrawApplication: '{{ __('applications.labels.withdraw_application') }}',
                    },
                    status: {
                        accepted: '{{ ucfirst(__('applications.status.accepted')) }}',
                        declined: '{{ ucfirst(__('applications.status.declined')) }}',
                        pending: '{{ ucfirst(__('applications.status.pending')) }}',
                        withdrawn: '{{ ucfirst(__('applications.status.withdrawn')) }}',
                    },
                }"
                :races="{{ $races }}"
            ></account-applications>
        </div>
    </div>
@endsection

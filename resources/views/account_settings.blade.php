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
        </div>
    </div>
@endsection

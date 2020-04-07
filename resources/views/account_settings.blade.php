@extends('template')

@section('title', 'Account Settings')

@section('content')
    <div id="app">
        <header class="container-fluid bg-tavern py-7 text-light">
            <div class="content">
                <h1 class="text-center">Account Settings</h1>
            </div>
        </header>
        <div class="container py-6 text-light">
            <p class="lead">Here you can modify the following account settings:</p>
            <account-settings
                :default-values="{
                    nickname: '{{ $nickname }}',
                    email: '{{ $email }}',
                    battletag: '{{ $battletag }}',
                    discordTag: '{{ $discord }}',
                }"
                :user-id="{{ $user->id }}"
            ></account-settings>
            <account-applications
                :classes="{{ $classes }}"
                :lang="{
                    on: '{{ __('applications.on') }}',
                    labels: {
                        damage: '{{ __('applications.labels.damage') }}',
                        healer: '{{ __('applications.labels.healer') }}',
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

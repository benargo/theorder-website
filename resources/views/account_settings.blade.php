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
                    on: '{{ Lang::get('applications.on') }}',
                    labels: {
                        damage: '{{ Lang::get('applications.labels.damage') }}',
                        healer: '{{ Lang::get('applications.labels.healer') }}',
                        role: '{{ Lang::get('applications.role') }}',
                        status: '{{ Lang::get('applications.labels.status') }}',
                        tank: '{{ Lang::get('applications.labels.tank') }}',
                        withdrawApplication: '{{ Lang::get('applications.labels.withdraw_application') }}',
                    },
                    status: {
                        accepted: '{{ ucfirst(Lang::get('applications.status.accepted')) }}',
                        declined: '{{ ucfirst(Lang::get('applications.status.declined')) }}',
                        pending: '{{ ucfirst(Lang::get('applications.status.pending')) }}',
                        withdrawn: '{{ ucfirst(Lang::get('applications.status.withdrawn')) }}',
                    },
                }"
                :races="{{ $races }}"
            ></account-applications>
        </div>
    </div>
@endsection

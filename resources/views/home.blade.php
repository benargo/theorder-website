@extends('template')

@section('title', __('meta.title'))

@section('content')
    <div class="container-fluid full-height welcome-home bg-guildshot-side text-light">
        <div class="content">
            <h1 class="display-2">
                {{ __('meta.title') }}
            </h1>
            <h2>
                {{ __('meta.realm') }}
            </h2>
        </div>
    </div>
    <div class="bg-dark extra-padding-top extra-padding-bottom text-light">
        <div class="container">
            <div class="col-12">
                <img src="{{ asset('images/guild_emblem.png') }}" class="float-right" alt="Guild Emblem">
                <h2>{{ __('home.who_we_are') }}</h2>
                {!! __('home.introduction') !!}
            </div>
        </div>
    </div>
    <div class="full-height bg-kitty-meeting extra-padding-top extra-padding-bottom text-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>{{ __('home.meet_the_officers') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 officers-card">
                    <img class="rounded float-left" src="https://render-api-eu.worldofwarcraft.com/static-render/eu/{{ $guild_master->character->thumbnail }}" alt="{{ $guild_master->character->name }}" height="84">
                    <div class="officers-card-body">
                        <h3 class="card-title">{{ $guild_master->character->name }}</h3>
                        <p class="card-text">{{ __('home.guild_master') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($officers as $officer)
                    <div class="col-12 col-md-6 col-lg-4 officers-card">
                        @if ($officer->character->name == 'Animorphus')
                            <img class="rounded float-left" src="{{ asset('images/animorphus.jpg') }}" alt="{{ $officer->character->name }}" height="84">
                        @else
                            <img class="rounded float-left" src="https://render-api-eu.worldofwarcraft.com/static-render/eu/{{ $officer->character->thumbnail }}" alt="{{ $officer->character->name }}" height="84">
                        @endif
                        <div class="officers-card-body">
                            <h3 class="card-title">{{ $officer->character->name }}</h3>
                            @if ($officer->character->name == 'Animorphus')
                                <p class="card-text">{{ __('home.animorphus') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <p>{{ __('home.kitty_meeting') }}</p>
        </div>
    </div>
@endsection

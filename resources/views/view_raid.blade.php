@extends('template')

@section('title', 'Raiding with The Order')

@section('content')
    <div id="app">
        <header class="container-fluid bg-{{ strtolower(data_get($instances->first(), 'abbr')) }} py-7 text-light">
            <div class="content">
                <h1 class="text-center">
                    {{ $instances->implode('name', '/') }}
                </h1>
            </div>
        </header>
        <div class="container py-6 text-light">
            <div class="row mb-6">
                <div class="alert alert-warning col-12 text-center" role="alert">
                    <font-awesome-icon :icon="['fas', 'debug']" class="align-middle mr-3" size="2x"></font-awesome-icon>
                    <strong>This feature is new and is currently being tested. Please report any bugs to Ben/Tinkletoes as a matter of urgency.</strong>
                </div>
            </div>
            <div class="row mb-6">
                <div class="col col-md-8">
                    <h2>Raid: {{ $instances->implode('name', '/') }}</h2>
                    <h3>{{ $raid->starts_at->format('l d F Y @ H:i T') }}</h3>
                    @if ($signups_are_open)
                        {{-- If raid signups are currently open... --}}
                        <h4>Sign Up Here</h4>
                        <raid-signup-form
                            :raid-id="{{ $raid->id }}"
                            :default-character-name="{{ $default_character_name }}"
                            :default-class-id="{{ $default_class_id }}"
                            :default-role="{{ $default_role }}"
                            :classes="{{ $classes->toJson() }}"
                            :signed-up="{{ $signed_up }}">
                        </raid-signup-form>
                    @elseif ($raid->starts_at->isBefore(now()))
                        {{-- If the raid has already happened... --}}
                        <p>This raid has already happened.</p>
                    @elseif ($signups_open_time->isAfter(now()))
                        {{-- If this raid is more than a week away... --}}
                        <div class="alert alert-info mt-3" role="alert">
                            Signups are not currently open for this raid. Please check back on {{ $signups_open_time->format('l d F Y @ H:i T') }}
                        </div>
                    @elseif ($signups_close_time->isAfter(now()))
                        {{-- If the raid is less than 24 hours away... --}}
                        <div class="alert alert-danger mt-3" role="alert">
                            Signups are now closed for this raid.
                        </div>
                    @endif
                    @if (count($confirmed_team))
                        <h3>Raid Team</h3>
                        <p>This is the raid team as randomly selected on {{ $signups_close_time->format('l d F Y @ H:i T') }}.</p>
                    @endif
                </div>
                <div class="col col-md-4">
                    <h3>Raid Calendar</h3>
                    <raid-calendar default-view="listMonth"></raid-calendar>
                </div>
            </div>
        </div>
    </div>
@endsection

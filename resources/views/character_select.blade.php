@extends('template')

@section('title', __('account.character_select_title'))

@section('content')
    <div class="full-height bg-dark-portal text-light extra-padding-top extra-padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>{{ __('account.character_select_title') }}</h1>
                    <p class="lead">{{ __('account.character_select_lead') }}</p>
                </div>
            </div>
            <div class="row justify-content-md-center">
                @if (isset($error))
                    <div class="alert alert-danger col-md-auto" role="alert">
                        {!! $error !!}
                    </div>
                @endif
                @if (isset($alert))
                    <div class="alert alert-warning col-md-auto" role="alert">
                        {!! $alert !!}
                    </div>
                @endif
                <character-select-confirmation lang="{{ __('account.character_select_confirmation') }}"></character-select-confirmation>
            </div>
            @if (isset($characters))
                <div class="row">
                    <div class="col-12">
                        <h2>Silvermoon</h2>
                    </div>

                    @foreach ($characters->pull('Silvermoon') as $character)
                        {{-- <character-select-button
                            name="{{ $character->name }}"
                            realm="{{ $character->realm }}"
                            summary="{{ __('account.character_summary', [
                                'level' => $character->level,
                                'race' => $races->getRace($character->race)->name,
                                'class' => $classes->getClass($character->class)->name,
                            ]) }}"
                            thumbnail="{{ $character->thumbnail }}">
                        </character-select-button> --}}
                        <div class="col-12 col-md-4">
                            <a class="character-select-button" href="#" role="button">
                                <img class="character-select-avatar" src="https://render-api-eu.worldofwarcraft.com/static-render/eu/{{ $character->thumbnail }}" alt="" width="84">
                                <div class="character-select-body">
                                    <h3 class="card-title">{{ $character->name }}</h5>
                                    <p class="card-text">
                                        {{ __('account.character_summary', [
                                            'level' => $character->level,
                                            'race' => $races->getRace($character->race)->name,
                                            'class' => $classes->getClass($character->class)->name,
                                        ]) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12">
                        <h2>Chamber of Aspects</h2>
                    </div>

                    @foreach ($characters->pull('Chamber of Aspects') as $character)
                        <div class="col-12 col-md-4">
                            <a class="character-select-button" href="#" role="button">
                                <img class="character-select-avatar" src="https://render-api-eu.worldofwarcraft.com/static-render/eu/{{ $character->thumbnail }}" alt="" width="84">
                                <div class="character-select-body">
                                    <h3 class="card-title">{{ $character->name }}</h5>
                                    <p class="card-text">
                                        {{ __('account.character_summary', [
                                            'level' => $character->level,
                                            'race' => $races->getRace($character->race)->name,
                                            'class' => $classes->getClass($character->class)->name,
                                        ]) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @foreach ($characters as $realm => $chars)
                    <div class="row">
                        <div class="col-12">
                            <h2>{{ $realm }}</h2>
                        </div>

                        @foreach ($chars as $character)
                            <div class="col-12 col-md-4">
                                <a class="character-select-button" href="#" role="button">
                                    <img class="character-select-avatar" src="https://render-api-eu.worldofwarcraft.com/static-render/eu/{{ $character->thumbnail }}" alt="" width="84">
                                    <div class="character-select-body">
                                        <h3 class="card-title">{{ $character->name }}</h5>
                                        <p class="card-text">
                                            {{ __('account.character_summary', [
                                                'level' => $character->level,
                                                'race' => $races->getRace($character->race)->name,
                                                'class' => $classes->getClass($character->class)->name,
                                            ]) }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

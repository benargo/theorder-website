@extends('template')

@section('title', 'Join The Order')

@section('content')
    <div id="app">
        <header class="container-fluid bg-ironforge py-7 text-light">
            <div class="content">
                <h1 class="text-center">Join The Order</h1>
            </div>
        </header>
        <div class="container py-6 text-light">
            <p class="lead">The Order is always looking for talented individuals, over the age of 18, with the aptitude for fun and adventure. Applications are simple and straightforward, all you need to do is fill out the details below and one of the Inner Circle will be in touch.</p>
            <join-form
                :classes="{{ $classes->toJson() }}"
                discord-url="{{ route('discord-channel', ['channel' => 552893734266863617]) }}"
                :races="{{ $races->toJson() }}"
                cannot-apply-again-until-date="{{ $application ? $application->canApplyAgainWhen()->format('jS F Y') : '{date}' }}"
                :lang="{
                    nextSteps: '{!! Lang::get('applications.next_steps') !!}',
                }"
                @isset ($application)
                    status="{{ $application->getStatus() }}"
                @endisset
            ></join-form>
        </div>
    </div>
@endsection

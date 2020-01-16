@extends('template')

@section('title', 'Raiding Schedule')

@section('content')
    <div id="app">
        <header class="container-fluid bg-kelthuzad py-7 text-light">
            <div class="content">
                <h1 class="text-center">
                    Raiding Schedule
                </h1>
            </div>
        </header>
        <div class="py-6 text-light">
            <raid-schedular :instances="{{ $instances }}"></raid-schedular>
        </div>
    </div>
@endsection

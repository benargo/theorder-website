@extends('template')

@section('title', 'Guild Bank')

@section('content')
    <div id="app">
        <header class="container-fluid bg-ironforge-bank py-7 text-light">
            <div class="content">
                <h1 class="text-center">Guild Bank</h1>
            </div>
        </header>
        <div class="container mt-6">
            <div class="alert alert-warning" role="alert">
                <font-awesome-icon :icon="['fas', 'construction']" class="align-middle mr-3" size="4x"></font-awesome-icon>
                <strong>This feature is still under development. Expect many parts of it not to work.</strong>
            </div>
        </div>
        <guild-bank-viewer></guild-bank-viewer>
    </div>
@endsection

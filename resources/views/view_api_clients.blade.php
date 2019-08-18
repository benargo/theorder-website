@extends('template')

@section('title', __('controlpanel.control_panel'))

@section('content')
    <div id="app" class="page-control-panel-index">
        <header class="container-fluid bg-engineering py-7">
            <div class="content">
                <h1 class="text-center">
                    Stock Addon Settings
                </h1>
            </div>
        </header>
        <div class="container py-7">
            <p class="lead mb-5">In order to use the Stock addon, you first need to create an OAuth Client. This is required in order to authenticate with the API.</p>
            <passport-clients></passport-clients>
        </div>
    </div>
@endsection

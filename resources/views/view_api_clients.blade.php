@extends('template')

@section('title', __('controlpanel.control_panel'))

@section('content')
    <div id="app" class="page-control-panel-index">
        <div class="container-fluid bg-engineering extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">
                    {{ __('controlpanel.stock_addon_settings') }}
                </h1>
            </div>
        </div>
        <div class="bg-brown-texture extra-padding-top extra-padding-bottom text-light">
            <api-clients>

            </api-clients>
        </div>
    </div>
@endsection

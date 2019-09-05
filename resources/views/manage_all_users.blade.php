@extends('template')

@section('title', $title)

@section('content')
    <div id="app">
        <header class="container-fluid bg-engineering extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">{{ $title }}</h1>
            </div>
        </header>
        <all-users-manager class="container extra-padding-top extra-padding-bottom text-light"
            :lang="{

            }">
        </all-users-manager>
    </div>
@endsection

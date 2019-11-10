@extends('template')

@section('title', 'Manage Guild Bankers')

@section('content')
    <div id="app">
        <header class="container-fluid bg-ironforge-bank py-7 text-light">
            <div class="content">
                <h1 class="text-center">Manage Guild Bankers</h1>
            </div>
        </header>
        <div class="container my-6">
            <div class="row mb-3">
                <div class="col">
                    <p class="lead">Here you can see all the characters who have been authorised to act as guild bankers. Any attempts to update the stock data with characters who aren&apos;t listed here will be rejected.</p>
                </div>
            </div>
            <manage-bankers></manage-bankers>
        </div>
    </div>
@endsection

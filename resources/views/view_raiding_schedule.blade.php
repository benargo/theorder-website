@extends('template')

@section('title', 'Raiding with The Order')

@section('content')
    <div id="app">
        <header class="container-fluid bg-kelthuzad py-7 text-light">
            <div class="content">
                <h1 class="text-center">Raiding with The Order</h1>
            </div>
        </header>
        <div class="container py-6 text-light">
            <div class="row mb-6">
                <div class="col">
                    <div class="alert alert-warning col-12 text-center" role="alert">
                        <font-awesome-icon :icon="['fas', 'debug']" class="align-middle mr-3" size="2x"></font-awesome-icon>
                        <strong>This feature is new and is currently being tested. Please report any bugs to Ben/Tinkletoes as a matter of urgency.</strong>
                    </div>
                </div>
            </div>
            <raid-calendar></raid-calendar>
        </div>
    </div>
@endsection

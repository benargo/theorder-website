@extends('errors::illustrated-layout')

@section('code', '504')
@section('title', Lang::get('Service Unavailable'))

@section('image')
    <div style="background-image: url({{ asset('/svg/503.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', 'Sorry, but due to technical difficulties with Blizzard\'s technical data we are currently not able to accept new applications.')

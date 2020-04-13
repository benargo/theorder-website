@extends('errors::illustrated-layout')

@section('code', '403')
@section('title', Lang::get('Forbidden'))

@section('image')
    <div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', Lang::get($exception->getMessage() ?: 'Sorry, you are forbidden from accessing this page.'))

@extends('template')

@section('title', __('meta.title'))

@section('content')
    <div id="app" class="page-home">
        <div class="container-fluid full-height section-fs-splash bg-goldshire text-light">
            <div class="content">
                <h1 class="display-2">
                    {{ __('meta.title') }}
                </h1>
                <h2>
                    {{ __('meta.realm') }}
                </h2>
            </div>
        </div>
        <div class="bg-dark extra-padding-top extra-padding-bottom section-introduction text-light">
            <div class="container">
                <div class="col-12">
                    <article class="article-introduction">
                        <h2>{{ __('home.who_we_are') }}</h2>
                        {!! __('home.introduction') !!}
                        <p class="class-icons">
                            @foreach($recruiting_classes as $class)
                                <img src="{{ asset('images/classicons.png') }}"
                                    alt="{{ $class->name }} Class icon"
                                    class="class-icon class-icon-{{ $class->name }} {{ $class->is_recruiting ?: ' class-icon-closed' }}"
                                    data-html="true"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="{{ ucwords(trans_choice('warcraft/classes.'.$class->name, 1)) }}">
                            @endforeach
                        </p>
                    </article>
                    <img src="{{ asset('images/guild_emblem.png') }}" alt="Guild Emblem" class="image-guild-emblem" height="228" width="216">
                </div>
            </div>
        </div>
        <div class="full-height section-inner-circle bg-homepage-inner-circle extra-padding-top extra-padding-bottom text-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>{{ __('home.meet_the_inner_circle') }}</h2>
                        {!! __('home.inner_circle_introduction') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

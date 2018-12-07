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
        <div class="extra-padding-top extra-padding-bottom section-introduction text-light">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-4 v-align-center">
                        <img src="{{ asset('images/guild_emblem.png') }}" alt="Guild Emblem" class="image-guild-emblem" height="228" width="216">
                    </div>
                    <div class="col-xs-12 col-md-8 order-md-first">
                        <article class="article-introduction">
                            <h2>{{ __('home.who_we_are') }}</h2>
                            {!! __('home.introduction') !!}
                            {{-- <p class="class-icons">
                                @foreach($recruiting_classes as $class)
                                    <img src="{{ asset('images/classicons.png') }}"
                                        alt="{{ $class->name }} Class icon"
                                        class="class-icon class-icon-{{ $class->name }} {{ $class->is_recruiting ?: ' class-icon-closed' }}"
                                        data-html="true"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="{{ ucwords(trans_choice('warcraft/classes.'.$class->name, 1)) }}">
                                @endforeach
                            </p> --}}
                        </article>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-inner-circle bg-homepage-inner-circle text-light extra-padding-bottom">
            <div class="bg-homepage-inner-circle-introduction">
                <div class="container">
                    <div class="row extra-padding-top extra-padding-bottom">
                        <div class="col-12">
                            <h2>{{ __('home.meet_the_inner_circle') }}</h2>
                            {!! __('home.inner_circle_introduction') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="d-none d-lg-block">
                    <div class="row no-gutters">
                        <div class="inner-circle-member col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-2" src="{{ asset('images/innercircle_alex.png') }}" alt="Alex" height="300">
                            </div>
                            <h4>Alex</h4>
                            <p>Balleknusern</p>
                            <p><flag iso="no" :squared="false" /><span class="sr-only">{{ __('nationalities.no') }}</span></p>
                        </div>
                        <div class="col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-1" src="{{ asset('images/innercircle_andy.png') }}" alt="Andy" height="325">
                            </div>
                            <h4>Andy</h4>
                            <p>Melkith</p>
                            <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                        </div>
                        <div class="col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-3" src="{{ asset('images/innercircle_ben.png') }}" alt="Ben" height="250">
                            </div>
                            <h4>Ben</h4>
                            <p>Saromius</p>
                            <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                        </div>
                        <div class="col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-1" src="{{ asset('images/innercircle_sam.png') }}" alt="Sam" height="350">
                            </div>
                            <h4>Sam</h4>
                            <p>Bolinn</p>
                            <p><flag iso="gb-wls" :squared="false" /><span class="sr-only">{{ __('nationalities.gb-wls') }}</span></p>
                        </div>
                        <div class="col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-2" src="{{ asset('images/innercircle_tommy.png') }}" alt="Tommy" height="400">
                            </div>
                            <h4>Tommy</h4>
                            <p>Blaazer</p>
                            <p><flag iso="se" :squared="false" /><span class="sr-only">{{ __('nationalities.se') }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="row d-lg-none">
                    <div id="carouselInnerCircle" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselInnerCircle" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselInnerCircle" data-slide-to="1"></li>
                            <li data-target="#carouselInnerCircle" data-slide-to="2"></li>
                            <li data-target="#carouselInnerCircle" data-slide-to="3"></li>
                            <li data-target="#carouselInnerCircle" data-slide-to="4"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_alex.png') }}" alt="Alex">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Alex</h4>
                                    <p>Balleknusern</p>
                                    <p><flag iso="no" :squared="false" /><span class="sr-only">{{ __('nationalities.no') }}</span></p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_andy.png') }}" alt="Andy">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Andy</h4>
                                    <p>Melkith</p>
                                    <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_ben.png') }}" alt="Ben">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Ben</h4>
                                    <p>Saromius</p>
                                    <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_sam.png') }}" alt="Sam">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Sam</h4>
                                    <p>Bolinn</p>
                                    <p><flag iso="gb-wls" :squared="false" /><span class="sr-only">{{ __('nationalities.gb-wls') }}</span></p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_tommy.png') }}" alt="Tommy">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Tommy</h4>
                                    <p>Blaazer</p>
                                    <p><flag iso="se" :squared="false" /><span class="sr-only">{{ __('nationalities.se') }}</span></p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselInnerCircle" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselInnerCircle" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

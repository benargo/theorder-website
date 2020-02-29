@extends('template')

@section('title', __('meta.title'))

@section('content')
    <div id="app" class="page-home font-size-md">
        <div class="bg-ragnaros">
            <div class="d-none d-md-block bg-video overflow-hidden vh-80 vh-md-95 exclude-navbar">
                <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
                    <source src="{{ asset('videos/bg_ragnaros.mp4') }}" type="video/mp4">
                </video>
            </div>
            <div class="bg-overlay container-fluid z-index-1 full-height vh-80 vh-md-95 exclude-navbar justify-content-center">
                <div class="text-center">
                    <h1 class="display-1">
                        {{ __('meta.title') }}
                    </h1>
                    <h2>
                        {{ __('meta.realm') }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="bg-brown-texture py-6">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-4 v-align-center">
                        <img src="{{ asset('images/guild_emblem.png') }}" alt="Guild Emblem" class="mb-3 mx-auto" height="228" width="216">
                    </div>
                    <div class="col-xs-12 col-md-8 order-md-first">
                        <article class="article-introduction">
                            <h2>Who We Are</h2>
                            <p>The Order is an exclusive and secretive World of Warcraft Classic casual raiding guild. We believe in helping and supporting our members, maintaining an active community and, most importantly, having fun.</p>
                            <p>We started out life on the <a href="https://elysium-project.org/" title="Elysium" rel="nofollow">Elysium project</a>, but with the official Classic release just around the corner we look forward to welcoming new and returning adventurers to our new home on Pyrewood Village.</p>
                            <p>Does what we do interest you? Are you thinking of joining? Great! We are currently recruiting the following classes for our raid team:</p>
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
                            <p>Social applications are always welcome, regardless of your class.</p>
                            <p>
                                <a href="{{ url('/join') }}" class="btn btn-primary btn-lg" role="button">
                                    Apply Now!
                                </a>
                        </p>
                        </article>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-inner-circle bg-menethil pb-6">
            <div class="bg-homepage-inner-circle-introduction">
                <div class="container">
                    <div class="row py-6">
                        <div class="col-12">
                            <h2>Meet the Inner Circle</h2>
                            <p>At the top of any guild is the master. Or in our case, we’re ruled by a council of five outstanding, bright, young(-ish) players who together form the Order’s inner circle. Here we all are, in this amazing screenshot.</p>
                            <p>You’re probably thinking: &lsquo;How do I become part of the inner circle?&rsquo; Well, to put it simply&hellip; you don’t. Sorry to disappoint you like that.</p>
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
                                <img class="d-block image-inner-circle z-index-1" src="{{ asset('images/innercircle_andy.png') }}" alt="Andy" height="450">
                            </div>
                            <h4>Andy</h4>
                            <p>Gambiit</p>
                            <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                        </div>
                        <div class="col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-3" src="{{ asset('images/innercircle_ben.png') }}" alt="Ben" height="200">
                            </div>
                            <h4>Ben</h4>
                            <p>Tinkletoes</p>
                            <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                        </div>
                        <div class="col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-1" src="{{ asset('images/innercircle_sam.png') }}" alt="Sam" height="350">
                            </div>
                            <h4>Sam</h4>
                            <p>Bolis</p>
                            <p><flag iso="gb-wls" :squared="false" /><span class="sr-only">{{ __('nationalities.gb-wls') }}</span></p>
                        </div>
                        <div class="col-lg text-center">
                            <div class="inner-circle-image-wrapper v-align-bottom">
                                <img class="d-block image-inner-circle z-index-2" src="{{ asset('images/innercircle_tommy.png') }}" alt="Tommy" height="350">
                            </div>
                            <h4>Tommy</h4>
                            <p>Monori</p>
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
                                    <p>Gambiit</p>
                                    <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_ben.png') }}" alt="Ben">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Ben</h4>
                                    <p>Tinkletoes</p>
                                    <p><flag iso="gb" :squared="false" /><span class="sr-only">{{ __('nationalities.gb') }}</span></p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_sam.png') }}" alt="Sam">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Sam</h4>
                                    <p>Bolis</p>
                                    <p><flag iso="gb-wls" :squared="false" /><span class="sr-only">{{ __('nationalities.gb-wls') }}</span></p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-image-wrapper">
                                    <img class="d-block carousel-image-inner-circle" src="{{ asset('images/innercircle_tommy.png') }}" alt="Tommy">
                                </div>
                                <div class="carousel-caption">
                                    <h4>Tommy</h4>
                                    <p>Monori</p>
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

        <div class="bg-brown-texture py-6">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <article class="article-introduction">
                            <h2>Join The Order</h2>
                            <p>We are currently recruiting the following classes for our raid team:</p>
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
                            <p>Social applications are always welcome, regardless of your class.</p>
                            <p>
                                <a href="{{ url('/join') }}" class="btn btn-primary btn-lg" role="button">
                                    Apply Now!
                                </a>
                        </p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

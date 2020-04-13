@extends('template')

@section('title', Lang::get('news.news'))

@section('content')
    <div id="app" class="page-news-index d-flex flex-column" data-spy="scroll" data-target="scrollspy-news-items" data-offset="0">
        <header class="container-fluid bg-engineering py-6 text-light">
            <div class="content">
                <h1 class="text-center">{{ $news_item->title }}</h1>
            </div>
        </header>
        <div class="pb-6 pt-6 text-light flex-1">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{{ Lang::get('meta.title') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('news.index') }}">{{ Lang::get('navigation.news') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $news_item->title }}</li>
                            </ol>
                        </nav>
                        <h2 class="h4 my-4"><em>
                            {{
                                Lang::get('news.attribution', [
                                        'author' => $news_item->author->nickname,
                                        'date' => $news_item->published_at->toDayDateTimeString(),
                                ])
                            }}
                        </em></h5>
                        @markdown($news_item->body)
                        {{-- @todo comments --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

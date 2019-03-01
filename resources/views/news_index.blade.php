@extends('template')

@section('title', __('news.news'))

@section('content')
    <div id="app" class="page-news-index">
        <header class="container-fluid bg-engineering extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">{{ __('news.news') }}</h1>
            </div>
        </header>
        <div class="bg-brown-texture extra-padding-top extra-padding-bottom text-light">
            <div class="container">
                <div class="row">
                    @foreach ($news_items as $news_item)
                        <div class="col col-md-6 mb-4">
                            <a href="{{ route('news.single', ['news_item' => $news_item->url]) }}" class="card text-light">
                                <h4 class="card-header bg-secondary">
                                    {{ $news_item->title }}
                                </h4>
                                <div class="card-body bg-brown">
                                    <h5 class="card-title">
                                        {{
                                            __('news.attribution', [
                                                    'author' => str_before($news_item->author->battletag, '#'),
                                                    'date' => $news_item->published_at->toDayDateTimeString(),
                                            ])
                                        }}
                                    </h5>
                                    <p class="card-text">
                                        {{ $news_item->body }}
                                    </p>
                                </div>
                                @if ($news_item->allows_comments)
                                    <div class="card-footer bg-brown text-muted text-right">
                                        {{ $news_item->comments()->count() }} Comments
                                    </div>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    {{ $news_items->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

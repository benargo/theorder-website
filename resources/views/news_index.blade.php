@extends('template')

@section('title', Lang::get('news.news'))

@section('content')
    <div id="app" class="page-news-index d-flex flex-column" data-spy="scroll" data-target="scrollspy-news-items" data-offset="0">
        <header class="container-fluid bg-engineering py-6 text-light">
            <div class="content">
                <h1 class="text-center">{{ Lang::get('news.news') }}</h1>
            </div>
        </header>
        <div class="pb-6 text-light flex-1">
            <div class="container">
                <div class="row">
                    @if ($news_items->count() > 0)
                        <div class="col-3 d-none d-md-block">
                            <div id="scrollspy-news-items" class="list-group pt-6 sticky-top">
                                @foreach ($news_items as $index => $news_item)
                                    <a class="list-group-item list-group-item-action" href="#{{ $news_item->id }}">
                                        {{ $news_item->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col pt-6">
                            @foreach ($news_items as $news_item)
                                <div class="card text-light mb-3" id="{{ $news_item->id }}">
                                    <h4 class="card-header bg-secondary">{{ $news_item->title }}</h4>
                                    <div class="card-body bg-brown">
                                        <h5 class="card-title">
                                            {{
                                                Lang::get('news.attribution', [
                                                        'author' => $news_item->author->nickname,
                                                        'date' => $news_item->published_at->toDayDateTimeString(),
                                                ])
                                            }}
                                        </h5>
                                        <div class="card-text">
                                            @markdown($news_item->body)
                                        </div>
                                    </div>
                                    @if ($news_item->allows_comments)
                                        <div class="card-footer bg-brown text-muted text-right">
                                            <a href="{{ route('news.single', ['news_item' => $news_item->url]) }}">
                                                {{ $news_item->comments()->count() }} Comments
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col pt-6">
                            <p class="lead text-center">{{ Lang::get('news.alerts.info_items_count_zero') }}</p>
                        </div>
                    @endif
                </div>
                <div class="row">
                    {{ $news_items->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

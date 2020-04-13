@extends('template')

@section('title', Lang::get('news.news_editor'))

@section('content')
    <div id="app" class="page-news-item-editor">
        <header class="container-fluid bg-engineering py-6 text-light">
            <div class="content">
                <h1 class="text-center">{{ Lang::get('news.news_editor') }}</h1>
            </div>
        </header>
        <div class="bg-brown-texture py-6 text-light">
            <news-item-editor
                {{-- article id prop --}}
                @if (isset($item_id))
                    :article-id="{{ $item_id }}"
                @endif

                {{-- array of available authors prop --}}
                :authors='{!! $authors->toJson() !!}'

                {{-- draft id prop --}}
                @if (isset($draft) && $draft instanceof App\Models\NewsItemDraft)
                    :draft-id="{{ $draft->id }}"
                @endif

                {{-- language lines --}}
                :lang="{
                    allowComments: '{{ Lang::get('news.allow_comments') }}',
                    articleId: '{{ Lang::get('news.article_id') }}',
                    author: '{{ Lang::get('news.author') }}',
                    basePath: '{{ Illuminate\Support\Str::after(route('news.index'), '://') }}',
                    comments: '{{ Lang::get('news.comments') }}',
                    currentlyPublished: '{{ Lang::get('news.currently_published') }}',
                    draftId: '{{ Lang::get('news.draft_id') }}',
                    errInvalidPublishDate: '{{ Lang::get('news.alerts.error_invalid_publish_date') }}',
                    errPublishing: '{{ Lang::get('news.alerts.error_publishing') }}',
                    labelUrl: '{{ Lang::get('news.labels.url') }}',
                    labelPublishDate: '{{ Lang::get('news.labels.publish_date') }}',
                    labelPublishDateHelp: '{{ Lang::get('news.labels.publish_date_help', [
                        'date' => date('d/m/Y H:i'),
                    ]) }}',
                    notCurrentlyPublished: '{{ Lang::get('news.not_currently_published') }}',
                    placeholder: '{{ Lang::get('news.placeholder') }}',
                    publishingOptions: '{{ Lang::get('news.publishing_options') }}',
                    publishNowButton: '{{ Lang::get('news.publish_now') }}',
                    publishLaterButton: '{{ Lang::get('news.publish_later') }}',
                    selectAuthor: '{{ Lang::get('news.select_author') }}',
                    startingTitle: '{{  Lang::get('news.click_to_set_title') }}',
                    togglePublishingOptions: '{{ Lang::get('news.sr_toggle_publishing_options') }}',
                    unpublishButton: '{{ Lang::get('news.unpublish') }}',
                    url: '{{ Lang::get('news.url') }}',
                    urlIsAvailable: '{{ Lang::get('news.url_is_available') }}',
                    urlNotAvailable: '{{ Lang::get('news.url_is_not_available') }}',
                    viewArticle: '{{ Lang::get('news.view_article') }}',
                }"

                {{-- current user object prop --}}
                :user="{
                    id: {{ $user->id }},
                    nickname: '{{ $user->nickname }}',
                }"
            ></news-item-editor>
        </div>
    </div>
@endsection

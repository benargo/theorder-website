@extends('template')

@section('title', __('news.news_editor'))

@section('content')
    <div id="app" class="page-news-item-editor">
        <header class="container-fluid bg-engineering extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">{{ __('news.news_editor') }}</h1>
            </div>
        </header>
        <div class="bg-brown-texture extra-padding-top extra-padding-bottom text-light">
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
                    allowComments: '{{ __('news.allow_comments') }}',
                    articleId: '{{ __('news.article_id') }}',
                    author: '{{ __('news.author') }}',
                    basePath: '{{ str_after(route('news.index'), '://') }}',
                    comments: '{{ __('news.comments') }}',
                    currentlyPublished: '{{ __('news.currently_published') }}',
                    draftId: '{{ __('news.draft_id') }}',
                    errInvalidPublishDate: '{{ __('news.alerts.error_invalid_publish_date') }}',
                    errPublishing: '{{ __('news.alerts.error_publishing') }}',
                    labelUrl: '{{ __('news.labels.url') }}',
                    labelPublishDate: '{{ __('news.labels.publish_date') }}',
                    labelPublishDateHelp: '{{ __('news.labels.publish_date_help', [
                        'date' => date('d/m/Y H:i'),
                    ]) }}',
                    notCurrentlyPublished: '{{ __('news.not_currently_published') }}',
                    placeholder: '{{ __('news.placeholder') }}',
                    publishingOptions: '{{ __('news.publishing_options') }}',
                    publishNowButton: '{{ __('news.publish_now') }}',
                    publishLaterButton: '{{ __('news.publish_later') }}',
                    selectAuthor: '{{ __('news.select_author') }}',
                    startingTitle: '{{  __('news.click_to_set_title') }}',
                    togglePublishingOptions: '{{ __('news.sr_toggle_publishing_options') }}',
                    unpublishButton: '{{ __('news.unpublish') }}',
                    url: '{{ __('news.url') }}',
                    urlIsAvailable: '{{ __('news.url_is_available') }}',
                    urlNotAvailable: '{{ __('news.url_is_not_available') }}',
                    viewArticle: '{{ __('news.view_article') }}',
                }"

                {{-- current user object prop --}}
                :user="{
                    id: {{ $user->id }},
                    battletag: '{{ $user->battletag }}',
                }"
            ></news-item-editor>
        </div>
    </div>
@endsection

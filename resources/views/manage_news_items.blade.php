@extends('template')

@section('title', __('news.news_items'))

@section('content')
    <div id="app" class="page-news-item-manager">
        <header class="container-fluid bg-engineering extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">{{ __('news.news_items') }}</h1>
            </div>
        </header>
        <div class="bg-brown-texture extra-padding-top extra-padding-bottom text-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <p class="lead">Below is a list of news items, including drafts that have not yet been published.</p>
                    </div>
                    <div class="col-12 col-md-4 text-md-right">
                        <a href="{{ url('/inner-circle/news/create') }}" class="btn btn-primary btn-lg" role="button">
                            <font-awesome-icon :icon="['fas', 'pen-fancy']"></font-awesome-icon>
                            {{ __('news.buttons.new') }}
                        </a>
                    </div>
                </div>
            </div>
            <news-item-manager
                :lang="{
                    buttons: {
                        cancel: '{{ __('news.buttons.cancel') }}',
                        delete: '{{ __('news.buttons.delete') }}',
                        deleteDraft: '{{ __('news.buttons.delete_draft') }}',
                        deleteItem: '{{ __('news.buttons.delete_item') }}',
                        edit: '{{ __('news.buttons.edit') }}',
                        next: '{{ __('news.buttons.next') }}',
                        previous: '{{ __('news.buttons.previous') }}',
                        unpublish: '{{ __('news.unpublish') }}',
                    },
                    modal: {
                        header: '{{ __('news.modal_confirm_delete.header') }}',
                        body: {
                            draft: '{{ __('news.modal_confirm_delete.body_draft') }}',
                            item: '{{ __('news.modal_confirm_delete.body_item') }}',
                        },
                    },
                    tableHeaders: {
                        title: '{{ __('news.table_headers.title') }}',
                        author: '{{ __('news.table_headers.author') }}',
                        publishedAt: '{{ __('news.table_headers.published_at') }}',
                        updatedAt: '{{ __('news.table_headers.updated_at') }}',
                        actions: '{{ __('news.table_headers.actions') }}',
                    },
                    tooltips: {
                        draft: '{{ __('news.tooltips.draft') }}',
                        scheduled: '{{ __('news.tooltips.scheduled') }}',
                    },
                    draft: '{{ __('news.draft') }}',
                    scheduled: '{{ __('news.scheduled') }}',
                    notPublished: '{{ __('news.not_published_short') }}',
                }"
            ></news-item-manager>
        </div>
    </div>
@endsection

@extends('template')

@section('title', Lang::get('news.news_items'))

@section('content')
    <div id="app" class="page-news-item-manager">
        <header class="container-fluid bg-engineering py-6 text-light">
            <div class="content">
                <h1 class="text-center">{{ Lang::get('news.news_items') }}</h1>
            </div>
        </header>
        <div class="py-6 text-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <p class="lead">{{ Lang::get('news.manage_lead') }}</p>
                    </div>
                    <div class="col-12 col-md-4 text-md-right">
                        <a href="{{ url('/inner-circle/news/create') }}" class="btn btn-primary btn-lg" role="button">
                            <font-awesome-icon :icon="['fas', 'pen-fancy']"></font-awesome-icon>
                            {{ Lang::get('news.buttons.new') }}
                        </a>
                    </div>
                </div>
            </div>
            <news-item-manager
                :lang="{
                    alerts: {
                        info_items_count_zero: '{{ Lang::get('news.alerts.info_items_count_zero') }}',
                    },
                    buttons: {
                        cancel: '{{ Lang::get('news.buttons.cancel') }}',
                        delete: '{{ Lang::get('news.buttons.delete') }}',
                        deleteDraft: '{{ Lang::get('news.buttons.delete_draft') }}',
                        deleteItem: '{{ Lang::get('news.buttons.delete_item') }}',
                        edit: '{{ Lang::get('news.buttons.edit') }}',
                        next: '{{ Lang::get('news.buttons.next') }}',
                        previous: '{{ Lang::get('news.buttons.previous') }}',
                        unpublish: '{{ Lang::get('news.unpublish') }}',
                    },
                    modal: {
                        header: '{{ Lang::get('news.modal_confirm_delete.header') }}',
                        body: {
                            draft: '{{ Lang::get('news.modal_confirm_delete.body_draft') }}',
                            item: '{{ Lang::get('news.modal_confirm_delete.body_item') }}',
                        },
                    },
                    tableHeaders: {
                        title: '{{ Lang::get('news.table_headers.title') }}',
                        author: '{{ Lang::get('news.table_headers.author') }}',
                        publishedAt: '{{ Lang::get('news.table_headers.published_at') }}',
                        updatedAt: '{{ Lang::get('news.table_headers.updated_at') }}',
                        actions: '{{ Lang::get('news.table_headers.actions') }}',
                    },
                    tooltips: {
                        draft: '{{ Lang::get('news.tooltips.draft') }}',
                        scheduled: '{{ Lang::get('news.tooltips.scheduled') }}',
                    },
                    draft: '{{ Lang::get('news.draft') }}',
                    scheduled: '{{ Lang::get('news.scheduled') }}',
                    notPublished: '{{ Lang::get('news.not_published_short') }}',
                }"
            ></news-item-manager>
        </div>
    </div>
@endsection

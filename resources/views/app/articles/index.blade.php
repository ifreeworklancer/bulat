@extends('layouts.app', ['page_title' => $page->translate('title')])

@section('breadcrumbs')
    <li>
        <span>
            {{ $page->translate('title') }}
        </span>
    </li>
@endsection

@section('content')

    <section id="content">
        <div class="container">
            <div class="d-flex align-items-center mb-5">
                <h1 class="mb-0 h3">{{ $page->translate('title') }}</h1>
                <div class="ml-5 flex-grow-1">
                    <hr>
                </div>
                <div class="ml-5">
                    <a href="#filters" class="btn btn-primary"
                       data-toggle="collapse" role="button" aria-expanded="false" aria-controls="filters">
                        <i class="material-icons mr-2">
                            filter_list
                        </i>
                        @lang('pages.articles.filters')
                    </a>
                </div>
            </div>

            @includeIf('partials.app.articles.filters')

            <div class="row">
                @forelse($articles as $article)
                    <div class="{{ $loop->index !== 0 ? 'col-md-6' : '' }} {{ in_array($loop->index, [0, 3]) ? 'col-lg-8' : 'col-lg-4' }}">
                        <a href="{{ route('app.articles.show', $article) }}" class="article-preview no-shadow">
                            <figure class="lozad article-preview__image{{ in_array($loop->index, [0, 1, 2, 3]) ? ' article-preview__image--large' : '' }}"
                                    data-background-image="{{ $article->preview }}"></figure>

                            <div class="p-3 bg-white position-relative">
                                <h5>
                                    {{ $article->translate('title') }}
                                </h5>
                                <p>
                                    {{ remove_tags($article->translate('body'), (in_array($loop->index, [0, 3]) ? 220 : 100)) }}
                                </p>
                                <span class="read-more">
                                    @lang('pages.articles.readmore')
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-sm text-center">
                        @lang('pages.articles.not_found')
                    </div>
                @endforelse
            </div>

            {{ $articles->appends(request()->except('page'))->links() }}
        </div>
    </section>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.js" defer></script>
@endpush
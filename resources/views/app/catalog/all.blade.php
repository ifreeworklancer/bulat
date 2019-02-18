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
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    @include('partials.app.catalog.filters')
                </div>

                <div class="col-md-8 col-lg-9">
                    <div class="container mx-0">
                        <div class="d-flex align-items-center mb-5">
                            <h1 class="mb-0 h3">{{ $page->translate('title') }}</h1>
                            <div class="ml-5 flex-grow-1">
                                <hr>
                                @if ($page->hasTranslation('description'))
                                    <p>{{ $page->translate('description') }}</p>
                                @endif
                            </div>
                        </div>

                        @include('partials.app.catalog.search')

                        <div class="row">
                            @forelse($products as $product)
                                <div class="col-md-6 col-lg-4">
                                    @include('partials.app.catalog.preview')
                                </div>
                            @empty
                                @lang('pages.catalog.not_found')
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
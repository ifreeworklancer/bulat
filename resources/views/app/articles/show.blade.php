@extends('layouts.app', ['page_title' => $article->translate('title')])

@section('breadcrumbs')
    <li>
        <a href="{{ route('app.articles.index') }}" class="text-dark">
            {{ $page->translate('title') }}
        </a>
    </li>
    <li class="breadcrumbs-separator">/</li>
    <li>
        <span>{{ $article->translate('title') }}</span>
    </li>
@endsection

@section('content')

    <figure class="article-image lozad" data-background-image="{{ $article->banner }}">
        <div class="infobar d-flex">
            <div class="infobar-item">
                <div class="infobar-item__heading">@lang('pages.articles.date')</div>
                <div class="infobar-item__body">
                    {!! $article->created_at->formatLocalized(app()->getLocale() == 'en' ? '%B <div class="date">%d</div> %Y' : '<div class="date">%d</div> <div>%B</div> %Y') !!}
                </div>
            </div>

            @auth
                <div class="infobar-item">
                    <div class="infobar-item__heading">@lang('common.favorites')</div>
                    <div class="infobar-item__body">
                        <i class="material-icons favorites-icon" onclick="togglefavorites()">
                            {{ $article->in_favorites ? 'star' : 'star_border' }}
                        </i>
                    </div>
                </div>
            @endauth
        </div>
    </figure>

    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <article class="px-4">
                        <h1 class="h4">
                            {{ $article->translate('title') }}
                        </h1>
                        @if($article->video)
                            <div class="video-feedback" data-youtube="{{$article->video}}"></div>

                        @endif

                        <div class="text-white">
                            {!! $article->translate('body') !!}
                        </div>
                    </article>
                </div>

                @if ($related->count())
                    <div class="col-md-4 col-lg-3">
                        <h4>@lang('pages.articles.popular')</h4>

                        @foreach($related as $item)
                            @include('partials.app.articles.preview', ['article' => $item, 'class' => 'no-shadow'])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
      function togglefavorites() {
        const el = event.target;
        event.preventDefault();

        axios.post('{{ route('app.articles.favorites', $article) }}')
          .then(function (response) {
            el.innerText = (response.data.status === 'added' ? 'star' : 'star_border');
          });
      }
    </script>
@endpush
<section id="articles" class="mt-0">
    <figure class="tabs-image d-none d-md-block lozad"
            data-background-image="{{ $articles->first()->banner }}"></figure>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 ml-auto">
                <h2 class="h3">@lang('pages.articles.title')</h2>

                @foreach($articles as $article)
                    <article class="tabs-item py-4 {{ $loop->index == 0 ? 'is-active' : '' }}"
                             tabindex="{{ $loop->iteration }}" data-image="{{ $article->banner }}">
                        <h5 class="mb-2">{{ $article->translate('title') }}</h5>
                        <div class="tabs-item__description mb-1">{{ remove_tags($article->translate('body')) }}</div>
                        <a href="{{ route('app.articles.show', $article) }}" class="read-more">
                            @lang('pages.articles.readmore')
                        </a>
                    </article>
                @endforeach

                <div class="mt-2">
                    <a href="{{ route('app.articles.index') }}" class="btn btn-primary h4 px-4 py-3 mb-0">
                        <i class="material-icons mr-2">assignment</i>
                        @lang('pages.home.articles.button')
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<a href="{{ route('app.articles.show', $article) }}" class="article-preview {{ $class ?? '' }}">
    <figure class="article-preview__image lozad"
            data-background-image="{{ $article->preview }}"></figure>
    <div class="p-3 bg-white position-relative">
        <h5>
            {{ $article->translate('title') }}
        </h5>
        <p class="smaller">
            {{ remove_tags($article->translate('body'), 50) }}
        </p>
        <span class="read-more">
            @lang('pages.articles.readmore')
        </span>
    </div>
</a>
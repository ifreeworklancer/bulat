<article class="article-preview">
    <a href="{{ route('app.articles.show', $article) }}"
       class="mb-3 article-preview__image lozad"
       data-background-image="{{ $article->preview }}"></a>

    <div class="px-3">
        <h6>
            <a href="{{ route('app.articles.show', $article) }}">
                {{ $article->translate('title') }}
            </a>
        </h6>
        <p class="smaller">
            {{ remove_tags($article->translate('body'), 50) }}
        </p>
        <a href="{{ route('app.articles.show', $article) }}" class="read-more">
            @lang('pages.articles.readmore')
        </a>
    </div>
</article>
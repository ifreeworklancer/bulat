@forelse($favorites as $key => $group)
    @if ($key === \App\Models\Catalog\Product::class)
        <h5>@lang('profile.favorites.products')</h5>

        <div class="row">
        @foreach($group as $item)
            <div class="col-md-6">
                @include('partials.app.catalog.preview', ['product' => $item->favoritable])
            </div>
        @endforeach
        </div>
    @elseif($key === \App\Models\Article\Article::class)
        <h5 class="mt-5">@lang('profile.favorites.articles')</h5>

        <div class="row">
            @foreach($group as $item)
                <div class="col-md-6">
                    @include('partials.app.articles.preview', ['article' => $item->favoritable])
                </div>
            @endforeach
        </div>
    @endif
@empty
    @lang('profile.not_found')
@endforelse
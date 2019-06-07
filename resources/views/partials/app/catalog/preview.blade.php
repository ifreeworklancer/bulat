<article class="mb-4">
    <a href="{{ route('app.catalog.show', $product) }}" class="product-preview">
        <figure class="product-preview__image lozad"
                data-background-image="{{ $product->preview }}"></figure>
        <div class="product-preview__info p-3">
            <div class="mb-auto">
                <h5 class="mb-1">{{ $product->translate('title') }}</h5>

                @if ($product->hasTranslation('description'))
                    <p class="smaller text-muted mb-1">{{ str_limit($product->translate('description'), 50) }}</p>
                @endif
            </div>

            <h6 class="mb-0 text-primary">
                {{ $product->price }}
                <small class="text-uppercase currency">
                    @lang('common.currency')
                </small>
            </h6>
        </div>
    </a>
</article>
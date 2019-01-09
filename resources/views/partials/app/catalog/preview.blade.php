<a href="{{ route('app.catalog.show', $product) }}"
   class="product-preview d-block">
    <figure class="product-preview__image"
            style="background-image: url({{ $product->preview }})"></figure>
    <div class="product-preview__info p-3">
        <h5>{{ $product->translate('title') }}</h5>

        @if ($product->hasTranslation('description'))
            <p class="text-body smaller">{{ str_limit($product->translate('description'), 50) }}</p>
        @endif

        <h6 class="mb-0">
            {{ $product->price }}
            <small class="text-uppercase currency">
                @lang('common.currency')
            </small>
        </h6>
    </div>
</a>
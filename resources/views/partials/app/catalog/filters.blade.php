<div class="catalog-filters">
    <h6 class="p-3 mb-0 bg-primary text-white d-flex align-items-center">
        <i class="material-icons mr-2">
            filter_list
        </i>
        @lang('pages.catalog.filter.title')
    </h6>

    <div class="p-3">
        @if ($categories->count())
            <h6 class="small mb-2">@lang('pages.catalog.filter.category.title')</h6>
            <ul class="list-unstyled small ml-3">
                @foreach($categories as $category)
                    <li>
                        @if ($category->slug !== request()->input('category'))
                            <a href="{{ build_filter_url(['category' => $category->slug]) }}">
                                {{ $category->translate('title') }}
                            </a>
                        @else
                            <s>{{ $category->translate('title') }}</s>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <h6 class="small mb-2">@lang('pages.catalog.filter.order.title')</h6>
        <ul class="list-unstyled small ml-3">
            @foreach(trans('pages.catalog.filter.order.fields') as $key => $field)
                <li>
                    @if ($key !== request()->input('order'))
                        <a href="{{ build_filter_url(['order' => $key]) }}">
                            {{ $field }}
                        </a>
                    @else
                        <s>{{ $field }}</s>
                    @endif
                </li>
            @endforeach
        </ul>

        @if (request()->hasAny(['category', 'order']))
            <div class="mt-4 small">
                <a href="{{ route('app.catalog.index') }}" class="btn btn-primary">
                    <i class="material-icons mr-2 smaller">delete</i>
                    <small>@lang('pages.catalog.filter.clear')</small>
                </a>
            </div>
        @endif
    </div>
</div>
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
            <ul class="list-unstyled smaller">
                @foreach($categories as $category)
                    <li>
                        <a href="{{ $category->query_filter }}"
                           class="d-inline-flex align-items-center">
                            <i class="material-icons mr-2">
                                @if (request()->has('category') && in_array($category->slug, explode(',',request()->get('category'))))
                                    check_box
                                @else
                                    check_box_outline_blank
                                @endif
                            </i>
                            {{ $category->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
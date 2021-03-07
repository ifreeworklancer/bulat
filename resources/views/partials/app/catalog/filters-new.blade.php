<div class="flex flex-wrap justify-center mb-4">
    @if ($categories->count())
        @foreach($categories as $category)
            <a href="{{$search? '?search='.$search.'&' : '?'}}category={{ $category->slug }}"
               class="mb-2 ml-2 btn {{ request()->has('category') && in_array($category->slug, explode(',',request()->get('category'))) ? 'btn-warning':'btn-filter' }}">
                {{ $category->title }}
            </a>
        @endforeach
        @if(request()->filled('category') || request()->filled('search'))
            <a href="{{ url()->current() }}" class="ml-2 btn btn-filter">
                @lang('pages.catalog.filter.clear')
            </a>
        @endif
    @endif

</div>
<section id="categories">
    <div class="container">
        <h2 class="h1 text-center mb-5">
            @lang('pages.home.categories.title')
        </h2>

        <div class="row categories">
            @foreach($categories as $category)
                <div class="col-lg-4">
                    <a href="{{ route('app.catalog.index', ['category' => $category->slug]) }}" class="category">
                        <figure class="category__image mb-3 lozad"
                                data-background-image="{{ $category->preview }}"></figure>

                        <h3 class="mb-0 h5 text-center">{{ $category->translate('title') }}</h3>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('app.catalog.index') }}" class="btn btn-primary h4 px-4 py-3 mb-0">
                <i class="material-icons mr-2">all_inclusive</i>
                @lang('pages.home.categories.button')
            </a>
        </div>
    </div>
</section>

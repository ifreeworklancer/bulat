<section id="categories">
    <div class="container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('app.catalog.index', ['category' => $category->slug]) }}" class="category">
                        <figure class="category__image mb-3"
                                style="background-image: url({{ $category->preview }});"></figure>

                        <h5 class="mb-0">{{ $category->translate('title') }}</h5>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
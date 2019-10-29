@extends('layouts.app', ['page_title' => $product->translate('title')])

@section('breadcrumbs')
    <li>
        <a href="{{ route('app.catalog.index') }}" class="text-dark">
            {{ $page->translate('title') }}
        </a>
    </li>
    <li class="breadcrumbs-separator">/</li>
    <li>
        <span>{{ $product->translate('title') }}</span>
    </li>
@endsection

@section('content')

    <section id="content" class="product-item">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="h5">{{ $product->translate('title') }}</h1>

                    <div class="position-relative mb-5">
                        <a href="{{ $product->banner }}">
                            <img data-src="{{ $product->banner }}" class="lozad"
                                 alt="{{ $product->translate('title') }}" data-fancybox="gallery"
                                 data-background-image="{{ $product->banner }}">
                        </a>

                        @if($product->hasMedia('uploads'))
                            <div class="mt-4">
                                <h6>@lang('pages.product.all_photos')</h6>

                                <div class="row no-gutters">
                                    @foreach($product->getMedia('uploads')->slice(1) as $photo)
                                        <div class="col-4 col-lg-3">
                                            <a href="{{ $photo->getUrl('banner') }}"
                                               data-fancybox="gallery"
                                               class="product-item__gallery-item lozad"
                                               data-background-image="{{$photo->getUrl('preview')}}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6 pl-md-4">
                    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end mb-4">
                        <div>
                            <h4 class="price mt-4">
                                <small class="text-muted">@lang('pages.product.price'):</small>
                                {{ number_format($product->price, 0, ',', ' ') }}
                                @lang('common.currency')
                            </h4>
                        </div>

                        <div class="ml-sm-auto text-right">
                            @if ($product->in_stock)
                                <p class="text-success">@lang('pages.product.in_stock')</p>
                            @else
                                <p class="text-danger">@lang('pages.product.out_of_stock')</p>
                            @endif

                            <div class="ml-auto">
                                @if (!$processing)
                                    <button class="btn btn-primary h4 px-4 py-3 mb-0"
                                            data-toggle="modal"
                                            data-target="#buyModal">
                                        <i class="material-icons mr-2">account_balance_wallet</i>
                                        @lang('pages.product.buy')
                                    </button>
                                @else
                                    <div class="bg-secondary d-inline-flex align-items-center text-white py-2 px-3">
                                        <i class="material-icons mr-2">check_box</i>
                                        @lang('pages.product.ordered')
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-white">
                        <p class="lead">{{ $product->translate('description') }}</p>
                        {!! $product->body !!}

                        <div class="mt-4">
                            <button class="btn btn-primary h4 px-4 py-3 mb-0"
                                    data-toggle="modal"
                                    data-target="#questionModal">
                                <i class="material-icons mr-2">chat</i>
                                @lang('pages.product.question')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($popular->count())
        <section id="popular-products">
            <div class="container">
                <div class="d-flex mb-3">
                    <h5 class="mb-0">@lang('pages.product.popular')</h5>
                    <div class="ml-auto">
                        <a href="{{ route('app.catalog.index') }}" class="btn btn-primary">
                            @lang('pages.product.catalog')
                        </a>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @foreach($popular as $item)
                        <div class="col-md-6 col-lg-3">
                            @include('partials.app.catalog.preview', ['product' => $item])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('app.catalog.order-modal')
    @include('app.catalog.question-modal')

@endsection

@push('scripts')
    <script>
      function togglefavorites() {
        const el = event.target;
        event.preventDefault();

        axios.post('{{ route('app.catalog.favorites', $product) }}')
          .then(function (response) {
            el.innerText = (response.data.status === 'added' ? 'star' : 'star_border');
          });
      }
    </script>
@endpush

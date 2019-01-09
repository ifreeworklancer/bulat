@forelse($orders as $status => $group)
    @if ($group->count())
        <h5 class="mb-2 {{ $loop->index > 0 ? 'mt-5' : '' }}">@lang('orders.statuses.'.$status)</h5>

        <div class="row">
            @foreach($group as $order)
                <div class="col-md-6">
                    <article class="d-flex p-2 border order--{{ $order->status }}">
                        <div class="mr-3 flex-shrink-0">
                            @if (in_array($order->status, ['processing', 'no_dial']))
                                <a href="{{ route('app.catalog.show', $order->product) }}">
                                    <img data-src="{{ $order->product->getFirstMediaUrl('products', 'thumb') }}"
                                         width="100" class="lozad" alt="">
                                </a>
                            @else
                                <img data-src="{{ $order->product->getFirstMediaUrl('products', 'thumb') }}"
                                     width="100" class="lozad" alt="">
                            @endif
                        </div>
                        <div class="flex-grow-0">
                            <h6 class="mb-1">
                                @if (in_array($order->status, ['processing', 'no_dial']))
                                    <a href="{{ route('app.catalog.show', $order->product) }}">
                                        {{ $order->product->translate('title') }}
                                    </a>
                                @else
                                    {{ $order->product->translate('title') }}
                                @endif
                            </h6>

                            @if ($order->product->hasTranslation('description'))
                                <p class="text-body small">
                                    {{ str_limit($order->product->translate('description'), 50) }}
                                </p>
                            @endif

                            <h6 class="mb-1">
                                {{ number_format($order->price, 0, ',', ' ') }}
                                @lang('common.currency')
                            </h6>

                            <p class="mb-0 text-muted text-right small">
                                {!! $order->created_at->formatLocalized(app()->getLocale() == 'en'
                                ? '%B, %d %Y at %R' : '%d %B %Y в %R') !!}
                            </p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
@empty
    @lang('profile.not_found')
@endforelse
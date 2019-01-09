@extends('layouts.admin', ['page_title' => 'Заказ №' . $order->id])

@section('content')

    <section id="content">
        <h1 class="h3 mb-4">Заказ №{{ $order->id }}</h1>

        <form action="{{ route('admin.orders.update', $order) }}" method="post">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Заказчик</h4>
                    @if ($order->user)
                        <h5 class="position-relative">
                            <div class="indicator bg-success"></div>
                            <a href="{{ route('admin.users.edit', $order->user) }}" class="underline">
                                {{ $order->user->name }}
                            </a>
                        </h5>

                        @if ($order->user->profile)
                            <p>
                                @if ($order->user->profile->phone_1)
                                    <a href="tel:{{$order->user->profile->phone_1}}" class="mr-2">
                                        {{ $order->user->profile->phone_1 }}
                                    </a>
                                @endif
                                @if ($order->user->profile->phone_2)
                                    <a href="tel:{{$order->user->profile->phone_2}}">
                                        {{ $order->user->profile->phone_2 }}
                                    </a>
                                @endif
                            </p>
                        @endif

                        <p>
                            <a href="mailto:{{ $order->user->email }}" class="dashed">
                                {{ $order->user->email }}
                            </a>
                        </p>

                        @if ($order->user->profile && $order->user->profile->country)
                            <p>
                                {{ $order->user->profile->country }}.
                                @if ($order->user->profile->city)
                                    {{ $order->user->profile->city }}.
                                @endif
                            </p>
                            @if ($order->user->profile->address)
                                <p>{{ $order->user->profile->address }}</p>
                            @endif
                        @endif
                    @else
                        <h5 class="position-relative">
                            <div class="indicator bg-warning"></div>
                            {{ $order->name }}
                        </h5>
                        <p>{{ $order->name }}</p>
                        <p class="mb-0">{{ $order->contact }}</p>
                    @endif

                    @if ($order->message)
                        <div class="form-group mb-0">
                            <label for="message">Сообщение</label>
                            <textarea class="form-control" id="message"
                                      name="message">{{ old('message') ?? $order->message }}</textarea>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <h4 class="mb-3">Товар</h4>
                    <div class="d-flex">
                        <div class="flex-shrink-0 mr-3">
                            <img src="{{ $order->product->getFirstMediaUrl('products', 'thumb') }}" alt="">
                        </div>
                        <div class="flex-grow-0">
                            <h5>
                                <a href="{{ route('app.catalog.show', $order->product) }}" class="underline"
                                   target="_blank">
                                    {{ $order->product->translate('title') }}
                                </a>
                            </h5>

                            @if ($order->product->hasTranslation('description'))
                                <p>{{ $order->product->translate('description') }}</p>
                            @endif
                            <h5>
                                {{ $order->price }} грн.
                                <small class="text-muted">
                                    ({{ $order->product->price }} грн.)
                                </small>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group">
                <label for="comment">Комментарий</label>
                <textarea class="form-control" id="comment"
                          name="comment">{{ old('comment') ?? $order->comment }}</textarea>
            </div>

            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-primary">
                        Обновить
                    </button>
                </div>
                <div class="col-auto">
                    <select name="status"
                            class="form-control {{ $order->status == 'declined' ? 'border-danger' : ($order->status == 'completed' ? 'border-success' : '') }}">
                        @foreach(\App\Models\Catalog\Order::$STATUSES as $status)
                            <option value="{{ $status }}"
                                    {{ $order->status == $status ? 'selected' : '' }}>
                                @lang('orders.statuses.'.$status)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </section>

@endsection
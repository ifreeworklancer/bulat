<h4>Контакт:</h4>
@if ($data->user instanceof \App\Models\User\User)
    <p>{{ $data->user->name }}, {{ $data->user->phone }} <{{ $data->user->email }}></p>
@else
    <p>{{ $data->name }}, {{ $data->contact }}</p>
@endif

<h4>Товар:</h4>
<p>
    <a href="{{ route('app.catalog.show', $product) }}" target="_blank">{{ $product->title }}</a>
</p>

@if ($data->message)
    <h4>Сообщение:</h4>
    <p>{{ $data->message }}</p>
@endif

<br>
<p>-----<br>{{ $order->created_at->formatLocalized('%d %B %Y') }}</p>
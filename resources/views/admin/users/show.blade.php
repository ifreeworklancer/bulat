@extends('layouts.admin', ['page_title' => $user->name])

@section('content')

    <section id="content">
        <h1 class="h3 mb-5">
            {{ $user->name }}
        </h1>

        <div class="row">
            <div class="col-md-6">
                <p>
                    <a href="mailto:{{ $user->email }}" class="dashed">
                        {{ $user->email }}
                    </a>
                </p>

                <p>
                    Зарегистрирован: <strong>{{ $user->created_at->format('d.m.Y H:i') }}</strong>
                </p>

                <div class="row no-gutters mt-4">
                    <div class="col-auto pr-2">
                        <div class="d-flex p-3 rounded bg-primary text-white align-items-center">
                            <div>Заказов</div>
                            <div class="ml-2 h2 mb-0">{{ $user->orders()->count() }}</div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="d-flex p-3 rounded bg-warning align-items-center">
                            <div>Оценок</div>
                            <div class="ml-2 h2 mb-0">{{ $user->applications()->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($user->profile)
                <div class="col-md-6">
                    <table class="table">
                        @if ($user->profile->phone_1)
                            <tr>
                                <td><nobr>Телефон 1</nobr></td>
                                <td>
                                    <a href="tel:{{$user->profile->phone_1}}" class="mr-2">
                                        {{ $user->profile->phone_1 }}
                                    </a>
                                </td>
                            </tr>
                        @endif

                        @if ($user->profile->phone_2)
                            <tr>
                                <td><nobr>Телефон 2</nobr></td>
                                <td>
                                    <a href="tel:{{$user->profile->phone_2}}">
                                        {{ $user->profile->phone_2 }}
                                    </a>
                                </td>
                            </tr>
                        @endif

                        @if ($user->profile->country)
                            <tr>
                                <td>Страна</td>
                                <td>{{ $user->profile->country }}</td>
                            </tr>
                        @endif

                        @if ($user->profile->city)
                            <tr>
                                <td>Город</td>
                                <td>{{ $user->profile->city }}</td>
                            </tr>
                        @endif

                        @if ($user->profile->address)
                            <tr>
                                <td>Адрес</td>
                                <td>{{ $user->profile->address }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            @endif
        </div>
    </section>

@endsection
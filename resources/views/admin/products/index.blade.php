@extends('layouts.admin', ['page_title' => 'Товары'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Товары</h1>
            <div class="ml-4">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    Создать новый товар
                </a>

                @if (count(request()->query()) && (count(request()->except('page'))))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-dark ml-4">
                        <i class="i-reload"></i>
                        Сбросить фильтры
                    </a>
                @endif
            </div>
        </div>

        <form class="my-4 d-flex">
            <div class="mr-2 flex-grow-1">
                <input type="text" name="q" value="{{ request()->get('q', null) }}" class="form-control"
                       placeholder="Поиск по товарам">
            </div>
            <button class="btn btn-primary">
                <i class="i-search"></i>
                Найти
            </button>
        </form>

        @if ($tags->count())
            <div class="mb-5 d-flex" style="font-size: 14px;">
                @foreach($tags as $tag)
                    <div class="d-inline-flex align-items-center bg-secondary text-white flex-nowrap rounded mr-2">
                        <span class="py-1 px-2">
                            {{ $tag->translate('title') }}
                        </span>
                        <a href="{{ $tag->query_filter }}"
                           class="p-2 bg-dark text-white bg-secondary text-white rounded-right"
                           style="line-height: 15px;">
                            &times;
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Название</th>
                <th>Категория</th>
                <th>Просмотры</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td width="280">
                        <a href="{{ route('admin.products.edit', $product) }}" class="underline">
                            {{ $product->translate('title') }}
                        </a>
                    </td>
                    <td>
                        @forelse($product->categories as $category)
                            <a href="{{ $category->query_filter }}"
                               class="bg-secondary text-white py-1 px-2 rounded small mr-1 nowrap">
                                {{ $category->title }}
                            </a>
                        @empty
                            ---
                        @endforelse
                    </td>
                    <td class="text-center">{{ $product->views_count }}</td>
                    <td width="150">{{ $product->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="100">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Товары пока не добавлены</td>
                </tr>
            @endforelse
        </table>

        {{ $products->appends(request()->except('page'))->links() }}
    </section>

@endsection

@extends('layouts.admin', ['page_title' => 'Товары'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Товары</h1>
            <div class="ml-4">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    Создать новый товар
                </a>
            </div>
        </div>

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
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="underline">
                            {{ $product->translate('title') }}
                        </a>
                    </td>
                    <td>
                        @forelse($product->categories as $category)
                            <span class="bg-secondary text-white py-1 px-2 rounded small mr-1 nowrap">{{ $category->translate('title') }}</span>
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
                    <td colspan="5" class="text-center">Товары пока не добавлены</td>
                </tr>
            @endforelse
        </table>

        {{ $products->appends(request()->except('page'))->links() }}
    </section>

@endsection

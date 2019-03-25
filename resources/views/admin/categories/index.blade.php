@extends('layouts.admin', ['page_title' => 'Категории'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Категории</h1>
            <div class="ml-4">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    Создать категорию
                </a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Название</th>
                <th class="text-center">Товаров в категории</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            @forelse($categories as $category)
                <tr>
                    <td width="20">{{ $category->id }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="underline">
                            {{ $category->translate('title') }}
                        </a>
                    </td>
                    <td class="text-center">{{ $category->products()->count() }}</td>
                    <td width="150">{{ $category->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="100">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.categories.destroy', $category) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Категории пока не добавлены
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $categories->appends(request()->except('page'))->links() }}
    </section>

@endsection

@push('scripts')
    <form method="post" id="delete" style="display: none">
        @csrf
        @method('delete')
    </form>

    <script>
      function deleteItem(route) {
        const form = document.getElementById('delete');
        const conf = confirm('Уверены?');

        if (conf) {
          form.action = route;
          form.submit();
        }
      }
    </script>
@endpush

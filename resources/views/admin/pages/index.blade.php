@extends('layouts.admin', ['page_title' => 'Страницы'])

@section('content')

    <section id="content">
        <h1 class="h3 mb-5">Страницы</h1>

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Заголовок</th>
                <th></th>
            </tr>
            </thead>

            @forelse($pages as $page)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="underline">
                            {{ $page->title }}
                        </a>
                    </td>
                    <td width="50">
                        <a href="{{ route('admin.pages.edit', $page) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Статьи пока не добавлены</td>
                </tr>
            @endforelse
        </table>
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
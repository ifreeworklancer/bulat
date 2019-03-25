@extends('layouts.admin', ['page_title' => 'Тэги'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Тэги</h1>
            <div class="ml-4">
                @if ($has_groups)
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                        Создать новый тэг
                    </a>
                @endif

                @if (request()->filled('group'))
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-dark">
                        Показать все тэги
                    </a>
                @endif
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Название</th>
                <th>Группа</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            @forelse($tags as $tag)
                <tr>
                    <td width="20">{{ $tag->id }}</td>
                    <td>
                        <a href="{{ route('admin.tags.edit', $tag) }}" class="underline">
                            {{ $tag->translate('title') }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.tags.index', ['group' => $tag->group]) }}" class="dashed">
                            {{ $tag->group->translate('title') }}
                        </a>
                    </td>
                    <td width="150">{{ $tag->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="100">
                        <a href="{{ route('admin.tags.edit', $tag) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.tags.destroy', $tag) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        @if ($has_groups)
                            Тэги пока не добавлены
                        @else
                            Для начала нужно
                            <a href="{{ route('admin.groups.create') }}"
                               class="btn btn-primary">Создать группу</a>
                        @endif
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $tags->appends(request()->except('page'))->links() }}
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

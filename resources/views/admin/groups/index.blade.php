@extends('layouts.admin', ['page_title' => 'Группы тэгов'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Группы тэгов</h1>
            <div class="ml-4">
                <a href="{{ route('admin.groups.create') }}" class="btn btn-primary">
                    Создать новую группу
                </a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Название</th>
                <th class="text-center">Тэгов</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            @forelse($groups as $group)
                <tr>
                    <td width="20">{{ $group->id }}</td>
                    <td>
                        <a href="{{ route('admin.groups.edit', $group) }}" class="underline">
                            {{ $group->translate('title') }}
                        </a>
                    </td>
                    <td width="80" class="text-center">{{ $group->tags->count() }}</td>
                    <td width="150">{{ $group->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="100">
                        <a href="{{ route('admin.groups.edit', $group) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.groups.destroy', $group) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Группы пока не добавлены</td>
                </tr>
            @endforelse
        </table>

        {{ $groups->links() }}
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

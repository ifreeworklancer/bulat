@extends('layouts.admin', ['page_title' => 'Ответы'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Ответы</h1>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Автор</th>
                <th>Дата создания</th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @forelse($answers as $answer)
                <tr>
                    <td style="width: 26px">{{ $answer->id }}</td>
                    <td>
                        <a href="{{ route('admin.answers.edit', $answer) }}" class="underline">
                        {{ $answer->user->name }}
                        </a>
                    </td>
                    <td width="150">{{ $answer->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="120" class="text-{{ $answer->status == 'confirmed' ? 'success' : ($answer->status == 'declined' ? 'danger' : 'default') }}">
                        @lang('profile.applications.statuses.' . $answer->status)
                    </td>
                    <td width="100">
                        <a href="{{ route('admin.answers.edit', $answer) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.answers.destroy', $answer) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Заполненых анкет пока нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $answers->appends(request()->except('page'))->links() }}
    </section>
    <form method="post" id="delete" style="display: none">
        @csrf
        @method('delete')
    </form>

@endsection
@push('scripts')
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

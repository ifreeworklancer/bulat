@extends('layouts.admin', ['page_title' => 'Вопросы'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Вопросы</h1>
            <div class="ml-4">
                <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                    Создать новый вопрос
                </a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Вопрос</th>
                <th class="text-center">Порядок вывода</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @forelse($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>
                        <a href="{{ route('admin.questions.edit', $question) }}" class="underline">
                            {{ $question->translate('title') }}
                        </a>
                    </td>
                    <td class="text-center"> {{ $question->order }} </td>
                    <td width="150">{{ $question->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="100">
                        <a href="{{ route('admin.questions.edit', $question) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.questions.destroy', $question) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Вопросы пока не добавлены</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $questions->appends(request()->except('page'))->links() }}
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

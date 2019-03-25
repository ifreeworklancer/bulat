@extends('layouts.admin', ['page_title' => 'Слайды'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Статьи</h1>
            <div class="ml-4">
                <a href="{{ route('admin.slides.create') }}" class="btn btn-primary">
                    Создать новый слайд
                </a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Изобр.</th>
                <th>Расположение</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @forelse($slides as $slide)
                <tr>
                    <td width="20">{{ $loop->iteration }}</td>
                    <td width="120">
                        <img src="{{ $slide->thumb }}" width="120" alt="">
                    </td>
                    <td>{{ $slide->slider->name }}</td>
                    <td width="100">
                        <a href="{{ route('admin.slides.edit', $slide) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.slides.destroy', $slide) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Слайды пока не добавлены</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $slides->appends(request()->except('page'))->links() }}
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
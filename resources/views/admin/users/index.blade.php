@extends('layouts.admin', ['page_title' => 'Пользователи'])

@section('content')

    <section id="content">
        <h1 class="h3 mb-5">
            Пользователи
        </h1>

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th width="20">#</th>
                <th>Имя</th>
                <th class="text-center">Профиль</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="underline">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td class="text-center h4">
                        <i class="i-{{ $user->profile ? 'thumbs-up' : 'close text-danger' }}"></i>
                    </td>
                    <td width="150">{{ $user->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="100">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-user"></i>
                        </a>
                        <button class="btn btn-danger btn-squire">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Пользователей пока нет
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $users->appends(request()->except('page'))->links() }}
    </section>

    @endsection
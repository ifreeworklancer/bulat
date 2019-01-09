@extends('layouts.admin', ['page_title' => 'Статьи'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center {{ $tags->count() ? 'mb-3' : 'mb-5' }}">
            <h1 class="h3 mb-0">Статьи</h1>
            <div class="ml-4">
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                    Создать новую статью
                </a>
            </div>
        </div>

        @if ($tags->count())
            <div class="mb-5 d-flex" style="font-size: 14px;">
                @foreach($tags as $tag)
                    <div class="d-inline-flex align-items-center bg-secondary text-white flex-nowrap rounded mr-2">
                        <span class="py-1 px-2 small">
                            {{ $tag->translate('title') }}
                        </span>
                        <a href="{{ urldecode(route('admin.articles.index', $tag->removeFromQueryFilter())) }}"
                           class="p-2 bg-dark text-white bg-secondary text-white rounded-right" style="line-height: 10px;">
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
                <th>Тэги</th>
                <th>Просмотры</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>

            @forelse($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="underline">
                            {{ $article->translate('title') }}
                        </a>
                    </td>
                    <td>
                        @forelse($article->tags as $tag)
                            <a href="{{ urldecode(route('admin.articles.index', $tag->buildQueryFilter())) }}"
                               class="bg-secondary text-white py-1 px-2 rounded small mr-1 nowrap">
                                {{ $tag->translate('title') }}
                            </a>
                        @empty
                            ---
                        @endforelse
                    </td>
                    <td class="text-center">{{ $article->views_count }}</td>
                    <td width="150">{{ $article->created_at->formatLocalized('%d %b %Y, %H:%M') }}</td>
                    <td width="100">
                        <a href="{{ route('admin.articles.edit', $article) }}"
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
                    <td colspan="5" class="text-center">Статьи пока не добавлены</td>
                </tr>
            @endforelse
        </table>

        {{ $articles->appends(request()->except('page'))->links() }}
    </section>

@endsection

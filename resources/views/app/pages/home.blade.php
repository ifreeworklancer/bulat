@extends('layouts.app', ['page_title' => trans('pages.home.title'), 'header_class' => 'is-light'])

@section('content')

    <h1 hidden>{{ config('app.name') . (isset($page_title) ? ' | ' . $page_title : '') }}</h1>

    @includeWhen(isset($slides) && $slides->count(), 'partials.app.home.slider')
    @includeWhen($categories->count(), 'partials.app.home.categories')
    @includeWhen($articles->count(), 'partials.app.home.articles')

@endsection

@section('meta')
    <meta property="og:type" content="product.group">
    @foreach($categories as $category)
        @includeIf('partials.app.layout.meta', ['meta' => $category->meta()->first()])
        @if ($category->hasMedia('category'))
            <meta property="og:image" content="{{ $category->preview }}">
        @endif
    @endforeach
    @foreach($articles as $article)
        @includeIf('partials.app.layout.meta', ['meta' => $article->meta()->first()])
        @if ($article->hasMedia('articles'))
            <meta property="og:image" content="{{ $article->preview }}">
        @endif
    @endforeach
@endsection

@extends('layouts.app', ['page_title' => trans('pages.home.title'), 'header_class' => 'is-light'])

@section('content')

    @includeWhen($slides->count(), 'partials.app.home.slider')
    @includeWhen($categories->count(), 'partials.app.home.categories')
    @includeWhen($articles->count(), 'partials.app.home.articles')

@endsection
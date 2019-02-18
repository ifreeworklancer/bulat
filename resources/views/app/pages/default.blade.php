@extends('layouts.app', ['page_title' => $page->title])

@section('breadcrumbs')
    <li>
        <span>{{ $page->title }}</span>
    </li>
@endsection

@section('content')

    <section id="content">
        <div class="container">
            {!! $page->body !!}
        </div>
    </section>

@endsection
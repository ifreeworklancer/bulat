@extends('layouts.app', ['page_title' => trans('pages.thanks.title')])

@section('breadcrumbs')
    <li>
        <span>@lang('pages.thanks.title')</span>
    </li>
@endsection

@section('content')

    <section id="content">
        <div class="container text-center">
            <h1>@lang('pages.thanks.title')</h1>

            @if (session()->has('message') && session()->has('product'))
                <p>@lang(session()->get('message'), ['product' => session()->get('product')->translate('title')])</p>
            @else
                <p>@lang(session()->get('message'))</p>
            @endif
        </div>
    </section>

@endsection
@extends('layouts.app', ['page_title' => trans('pages.search.title')])

@section('breadcrumbs')
    <li>
        <span>@lang('pages.search.title')</span>
    </li>
@endsection

@section('content')

    <section id="content">
        <div class="container">
            <div class="row">
                @forelse($results as $result)
                    <div class="col-md-6 col-lg-4">
                        @include('partials.app.' . $result->category . '.preview', [$result->type => $result])
                    </div>
                @empty
                    @lang('pages.search.not_found', ['query' => $search])
                @endforelse
            </div>

            {{ $results->appends(request()->except('page'))->links() }}
        </div>
    </section>

@endsection
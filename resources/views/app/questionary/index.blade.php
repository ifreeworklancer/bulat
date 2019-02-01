@extends('layouts.app', ['page_title' => trans('pages.questionary.title')])

@section('breadcrumbs')
    <li>
        <span>@lang('pages.questionary.title')</span>
    </li>
@endsection

@section('content')

    <section id="content">
        <div class="container">
            <form action="{{ route('app.questionary.store') }}" method="post">
                @csrf

                @foreach ($questions as $question)
                    <h2>{{ $question->translate('title') }}</h2>

                    <div class="form-group">
                        <label for="answer-{{ $loop->iteration }}">@lang('pages.questionary.answer')</label>
                        <input type="text" class="form-control" id="answer-{{ $loop->iteration }}"
                               name="answers[{{$question->translate('title')}}]" required>
                    </div>
                @endforeach

                <div class="mt-4">
                    <button class="btn btn-primary">@lang('pages.questionary.save')</button>
                </div>
            </form>
        </div>
    </section>

@endsection

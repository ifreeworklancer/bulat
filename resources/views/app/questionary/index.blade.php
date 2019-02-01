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
                    <h5 class="mb-2">{{ $question->title }}</h5>

                    <div class="form-group">
                        <textarea class="form-control" id="answer-{{ $loop->iteration }}"
                                  name="answers[{{$question->title}}]">{{ old('answers.' . $question->title) }}</textarea>
                    </div>
                @endforeach

                <images-uploader></images-uploader>

                <div class="mt-4">
                    <button class="btn btn-primary">@lang('pages.questionary.save')</button>
                </div>
            </form>
        </div>
    </section>

@endsection

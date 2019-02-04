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
                    <div class="d-flex mb-4">
                        <div class="text-secondary">
                            #{{ $loop->iteration }}
                        </div>

                        <div class="ml-3 flex-grow-1">
                            <label for="answer-{{ $loop->iteration }}" class="d-block mb-2 text-primary">
                                <strong>{{ $question->title }}</strong>
                            </label>

                            <div class="form-group">
                        <textarea class="form-control" id="answer-{{ $loop->iteration }}"
                                  name="answers[{{$question->title}}]">{{ old('answers.' . $question->title) }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach

                <images-uploader></images-uploader>

                <div class="mt-4 text-center">
                    <button class="btn btn-primary h4 px-4 py-3 mb-0">
                        <i class="material-icons mr-2">send</i>
                        @lang('pages.questionary.save')
                    </button>
                </div>
            </form>
        </div>
    </section>

@endsection

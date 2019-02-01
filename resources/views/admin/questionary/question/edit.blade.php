@extends('layouts.admin', ['page_title' => $question->translate('title')])

@section('content')
    <section id="content">
        <form action="{{ route('admin.questions.update', $question) }}" method="post">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-lg-9">
                    <block-editor title="{{ $question->translate('title') }}">
                        @foreach(config('app.locales') as $lang)
                            <div slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang . '.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Вопрос</label>
                                    <input type="text" class="form-control" id="title"
                                           name="{{$lang}}[title]"
                                           value="{{ old($lang . '.title') ?? $question->translate('title') }}"
                                           required>
                                </div>
                            </div>
                        @endforeach
                    </block-editor>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="order">Порядок вывода</label>
                        <input type="number" class="form-control" name="order" id="order"
                               value="{{ old($question . '.order') ?? $question->order }}">
                    </div>
                </div>
            </div>


            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection

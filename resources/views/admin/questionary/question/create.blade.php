@extends('layouts.admin', ['page_title' => 'Новый вопрос'])

@section('content')

    <section id="content">
        <form action="{{ route('admin.questions.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-9">
                    <block-editor title="Новый вопрос">
                        @foreach(config('app.locales') as $lang)
                            <div slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang . '.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Вопрос</label>
                                    <input type="text" class="form-control" id="title"
                                           name="{{$lang}}[title]"
                                           value="{{ old($lang . '.title') }}" required>
                                </div>

                                <label>Варианты ответов:</label>

                                @foreach(range(1, 4) as $variant)
                                    <div class="form-group d-flex align-items-center">
                                        <div class="mr-2 text-primary">
                                            <label for="variant-{{ $variant }}" class="mb-0">#{{$variant}}</label>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control" id="variant-{{ $variant }}"
                                                   name="variant[{{$variant}}][{{$lang}}]">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </block-editor>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="order">Порядок вывода</label>
                        @if($questions->count())
                            <input type="number" class="form-control" name="order" id="order"
                                   value="{{ old('order') ?? \App\Models\Questionary\Question::latest()->first()->id + 1 }}">
                        @else
                            <input type="number" class="form-control" name="order" id="order"
                                   value="1">
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection

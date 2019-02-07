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
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Вопрос</label>
                                    <input type="text" class="form-control" id="title"
                                           name="{{$lang}}[title]"
                                           value="{{ old($lang.'.title') ?? $question->translate('title', $lang) }}"
                                           required>
                                </div>

                                @if($question->variants->count())
                                    <label>Варианты ответов:</label>

                                    @foreach($question->variants as $variant)
                                        <div class="form-group d-flex align-items-center">
                                            <div class="mr-2 text-primary">
                                                #{{ $loop->iteration }}
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control" id="variant"
                                                       name="variant[{{$variant->id}}][{{$lang}}]"
                                                       value="{{ old($lang.'.title') ?? $variant->translate('title', $lang) }}">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
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
                                @endif
                            </fieldset>
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

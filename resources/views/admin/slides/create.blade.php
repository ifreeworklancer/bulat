@extends('layouts.admin', ['page_title' => 'Новый слайд'])

@section('content')

    <form action="{{ route('admin.slides.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <block-editor title="Новый слайд">
            @foreach(config('app.locales') as $lang)
                <div slot="{{ $lang }}">

                    <div class="form-group{{ $errors->has($lang . '.title') ? ' is-invalid' : '' }}">
                        <label for="title">Заголовок</label>
                        <input type="text" class="form-control" id="title"
                               name="{{$lang}}[title]"
                               value="{{ old($lang . '.title') }}" required>
                    </div>

                    <div class="form-group{{ $errors->has($lang . '.description') ? ' is-invalid' : '' }}">
                        <label for="subtitle">Описание</label>
                        <input type="text" class="form-control" id="subtitle"
                               name="{{$lang}}[description]"
                               value="{{ old($lang . '.description') }}" required>
                    </div>

                </div>
            @endforeach
        </block-editor>

        <image-uploader class="mt-3"></image-uploader>

        <input type="hidden" name="slider_id" value="1">

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="has_background" id="background" checked>
                <label class="custom-control-label" for="background">Применить темный ховер</label>
            </div>
        </div>

        <div class="mt-4 d-flex align-items-center">
            <button class="btn btn-primary">Сохранить</button>

            <div class="custom-control custom-checkbox ml-3">
                <input type="checkbox" class="custom-control-input"
                       id="published" name="is_visible" checked>
                <label class="custom-control-label" for="published">Опубликовать</label>
            </div>
        </div>
    </form>

@endsection
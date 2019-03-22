@extends('layouts.admin', ['page_title' => 'Слайд'])

@section('content')

    <form action="{{ route('admin.slides.update', $slide) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <image-uploader class="mt-3" src="{{ $slide->banner }}"></image-uploader>

        <input type="hidden" name="slider_id" value="1">

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="has_background" id="background"
                {{ $slide->has_background ? 'checked' : '' }}>
                <label class="custom-control-label" for="background">Применить темный ховер</label>
            </div>
        </div>

        <div class="mt-4 d-flex align-items-center">
            <button class="btn btn-primary">Сохранить</button>

            <div class="custom-control custom-checkbox ml-3">
                <input type="checkbox" class="custom-control-input"
                       id="published" name="is_visible" {{ $slide->is_visible ? 'checked' : '' }}>
                <label class="custom-control-label" for="published">Опубликовать</label>
            </div>
        </div>
    </form>

@endsection
@extends('layouts.admin', ['page_title' => $page->translate('title')])

@section('content')

    <section id="content">
        <form action="{{ route('admin.pages.update', $page) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <block-editor title="{{ $page->translate('title') }}">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                            <label for="title">Заголовок страницы</label>
                            <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                   value="{{ old($lang.'.title') ?? $page->translate('title', $lang) }}"
                                   required>
                            @if($errors->has($lang.'.title'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first($lang.'.title') }}
                                </div>
                            @endif
                        </div>

                        <label>Текст страницы</label>
                        <wysiwyg name="{{$lang}}[body]" class="mb-0"
                                 content="{{ old($lang.'.body') ?? $page->translate('body', $lang) }}"></wysiwyg>
                    </fieldset>
                @endforeach
            </block-editor>

            <div class="mt-4 d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection

@extends('layouts.admin', ['page_title' => $article->translate('title')])

@section('content')

    <section id="content">
        <form action="{{ route('admin.articles.update', $article) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <block-editor title="{{ $article->translate('title') }}">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Заголовок статьи</label>
                                    <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                           value="{{ old($lang.'.title') ?? $article->translate('title', $lang) }}"
                                           required>
                                    @if($errors->has($lang.'.title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first($lang.'.title') }}
                                        </div>
                                    @endif
                                </div>

                                <label>Текст статьи</label>
                                <wysiwyg name="{{$lang}}[body]" class="mb-0"
                                         content="{{ old($lang.'.body') ?? $article->translate('body', $lang) }}"></wysiwyg>
                            </fieldset>
                        @endforeach
                    </block-editor>
                    <div class="form-group">
                        <label for="video" class="mt-2">Видео</label>
                        <input id="video" type="text" name="video"
                               class="form-control"
                               value="{{ old('video') ?? $article->video }}">
                    @if ($tags->count())
                        <div class="mt-5">
                            <h3>Тэги статьи</h3>

                            @foreach($tags as $key => $group)
                                <h4 class="mt-3">{{ $groups->find($key)->translate('title') }}</h4>

                                <div class="d-flex flex-wrap">
                                    @foreach($group as $tag)
                                        <div class="border py-1 px-2 mr-3 mb-2 rounded">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="tag-{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}"
                                                        {{ $article->tags->pluck('id')->contains($tag->id) ? 'checked' : '' }}>
                                                <label class="custom-control-label nowrap"
                                                       for="tag-{{ $tag->id }}">
                                                    {{ $tag->translate('title') }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col">
                    <image-uploader src="{{ $article->getFirstMediaUrl('articles') }}"></image-uploader>
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>

                <div class="custom-control custom-checkbox ml-3">
                    <input type="checkbox" class="custom-control-input"
                           id="published" name="is_published"
                            {{ $article->is_published ? 'checked' : '' }}>
                    <label class="custom-control-label" for="published">Опубликовать</label>
                </div>
            </div>
        </form>
    </section>

@endsection

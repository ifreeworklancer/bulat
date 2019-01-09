@extends('layouts.admin', ['page_title' => $category->translate('title')])

@section('content')

    <section id="content">
        <form action="{{ route('admin.categories.update', $category) }}" method="post">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-md-9">
                    <block-editor title="{{ $category->translate('title') }}">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Название категории</label>
                                    <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                           value="{{ old($lang.'.title') ?? $category->translate('title', $lang) }}"
                                           required>
                                    @if($errors->has($lang.'.title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first($lang.'.title') }}
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                        @endforeach
                    </block-editor>
                </div>

                <div class="col-md">
                    <image-uploader src="{{ $category->getFirstMediaUrl('category') }}"></image-uploader>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection

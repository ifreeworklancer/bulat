@extends('layouts.admin', ['page_title' => $group->translate('title')])

@section('content')

    <section id="content">
        <form action="{{ route('admin.groups.update', $group) }}" method="post">
            @csrf
            @method('patch')

            <block-editor title="{{ $group->translate('title') }}">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                            <label for="title">Название группы</label>
                            <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                   value="{{ old($lang.'.title') ?? $group->translate('title', $lang) }}" required>
                            @if($errors->has($lang.'.title'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first($lang.'.title') }}
                                </div>
                            @endif
                        </div>
                    </fieldset>
                @endforeach
            </block-editor>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>

        </form>
    </section>

@endsection

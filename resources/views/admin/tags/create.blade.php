@extends('layouts.admin', ['page_title' => 'Создание нового тэга'])

@section('content')

    <section id="content">
        <form action="{{ route('admin.tags.store') }}" method="post">
            @csrf

            <block-editor title="Новый тэг">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                            <label for="title">Название тэга</label>
                            <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                   value="{{ old($lang.'.title') }}" required>
                            @if($errors->has($lang.'.title'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first($lang.'.title') }}
                                </div>
                            @endif
                        </div>
                    </fieldset>
                @endforeach

                @if ($groups->count())
                    <label for="groups">Принадлежит группе</label>
                    <select name="group_id" id="groups" class="form-control">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">
                                {{ $group->translate('title') }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </block-editor>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>

        </form>
    </section>

@endsection

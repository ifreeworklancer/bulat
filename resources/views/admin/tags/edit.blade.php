@extends('layouts.admin', ['page_title' => $tag->translate('title')])

@section('content')

    <section id="content">
        <form action="{{ route('admin.tags.update', $tag) }}" method="post">
            @csrf
            @method('patch')

            <block-editor title="{{ $tag->translate('title') }}">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                            <label for="title">Название тэга</label>
                            <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                   value="{{ old($lang.'.title') ?? $tag->translate('title', $lang) }}" required>
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
                            <option value="{{ $group->id }}"
                                    {{ $group->id === $tag->group_id ? 'selected' : '' }}>
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

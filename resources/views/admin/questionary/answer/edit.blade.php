@extends('layouts.admin', ['page_title' => 'Ответ №' . $answer->id])

@section('content')

    <section id="content">
        <div class="d-flex">
            <div class="flex-grow-1">
                <h1 class="h3 mb-2">Ответ <span class="text-primary">№{{ $answer->id }}</span></h1>
                <h3 class="mb-5"> Автор: <span class="text-primary">{{ $answer->user->name  }}</span></h3>
            </div>

            <div class="form-group">
                <form action="{{ route('admin.answers.update', $answer) }}" method="post">
                    @csrf
                    @method('patch')

                    <label for="status">Статус</label>
                    <select name="status" id="status" class="form-control w-auto"
                            onchange="event.target.form.submit()">
                        @foreach(\App\Models\Questionary\Answer::$statuses as $status)
                            <option value="{{ $status }}"
                                    {{ $status === $answer->status ? 'selected' : '' }}>
                                @lang('profile.applications.statuses.' . $status)
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        @foreach($answer->answers  as $question => $a)
            @if ($a)
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        #{{ $loop->iteration }}
                    </div>

                    <div>
                        <p class="mb-1"><strong>{{ $question }}</strong></p>

                        @if (!is_array($a))
                            <p>{{ $a }}</p>
                        @else
                            {{ implode(', ', $a) }}.
                        @endif
                    </div>
                </div>
            @endif
        @endforeach

        @if ($answer->hasMedia('answers'))
            <div class="row">
                @foreach($answer->getMedia('answers') as $media)
                    <div class="col-auto">
                        <a href="{{ $media->getFullUrl() }}" target="_blank">
                            <img src="{{ $media->getFullUrl('thumb') }}" alt="Error">
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.answers.index') }}" class="btn btn-primary">
                Вернуться назад
            </a>
        </div>
    </section>

@endsection


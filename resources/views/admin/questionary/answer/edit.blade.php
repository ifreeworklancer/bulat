@extends('layouts.admin', ['page_title' => 'Ответ №' . $answer->id])

@section('content')

    <section id="content">
        <h1 class="h3 mb-2">Ответ №{{ $answer->id }}</h1>
        <h3 class="mb-5"> Автор: {{ $answer->user->name  }}</h3>

        @foreach($answer->answers  as $question => $a)
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    #{{ $loop->iteration }}
                </div>

                <div>
                    <p class="mb-1"><strong>{{ $question }}</strong></p>
                    <p>{{ $a }}</p>
                </div>
            </div>
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


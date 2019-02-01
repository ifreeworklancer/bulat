@extends('layouts.admin', ['page_title' => 'Ответ №' . $answer->id])

@section('content')

    <section id="content">
        <h1 class="h3 mb-3">Ответ №{{ $answer->id }}</h1>
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

        <div class="mt-4">
            <a href="{{ route('admin.answers.index') }}" class="btn btn-primary">
                Вернутья назад
            </a>
        </div>
    </section>
@endsection


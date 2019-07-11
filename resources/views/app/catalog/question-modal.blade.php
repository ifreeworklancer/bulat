<div class="modal fade" id="questionModal" tabindex="-1" role="dialog"
     aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $product->title }}</h5>
                <i class="material-icons close" data-dismiss="modal" aria-label="Close">close</i>
            </div>
            <div class="modal-body">
                <form action="{{ route('app.catalog.question', $product) }}" method="post">
                    @csrf

                    @guest
                        <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                            <label for="name" class="small">@lang('forms.name')</label>
                            <input type="text" class="form-control border" id="name" name="name"
                                   value="{{ old('name') }}" required>
                            @if($errors->has('name'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('contact') ? ' is-invalid' : '' }}">
                            <label for="contact" class="small">@lang('forms.contact')</label>
                            <input type="text" class="form-control border" id="contact" name="contact"
                                   value="{{ old('contact') }}" required>
                            @if($errors->has('contact'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first('contact') }}
                                </div>
                            @endif
                        </div>
                    @endguest

                    <div class="form-group">
                        <label for="message" class="small">@lang('forms.message.question')</label>
                        <textarea class="form-control border" id="message" name="message">{{ old('message') }}</textarea>
                    </div>

                    <button class="btn btn-primary">@lang('forms.buttons.question')</button>
                </form>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('app.catalog.index') }}" class="my-5 search">
    <div class="d-flex position-relative">
        <i class="material-icons">search</i>
        <input type="search" name="search" class="form-control form-control--search"
               value="{{ old('search') ?? $search }}"
               placeholder="{{ trans('pages.catalog.search.placeholder') }}" required>
        <button class="btn btn-primary">@lang('pages.catalog.search.button')</button>
    </div>
</form>
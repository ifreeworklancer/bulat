<div class="d-flex align-content-between mb-4">
    <div class="ml-auto">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="btn btn-dark">
                <i class="material-icons mr-3">exit_to_app</i>
                @lang('profile.logout')
            </button>
        </form>
    </div>
</div>

<form action="{{ route('app.profile.update') }}" method="post">
    @csrf
    @method('patch')

    <div class="row">
        <div class="col-md-6 form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
            <label for="name">@lang('profile.select.name')</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $user->name }}"
                   required>
            @if($errors->has('name'))
                <div class="mt-1 text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        <div class="col-md-6 form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
            <label for="email">E-mail</label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ old('email') ?? $user->email }}" readonly required>
            @if($errors->has('email'))
                <div class="mt-1 text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form-group col-md-6">
            <label for="phone_1">@lang('profile.select.phone_1')</label>
            <input type="text" class="form-control" id="phone_1" name="phone_1"
                   value="{{ old('phone_1') ?? ($user->profile ? $user->profile->phone_1 : null) }}">
        </div>

        <div class="form-group col-md-6">
            <label for="phone_2">@lang('profile.select.phone_2')</label>
            <input type="text" class="form-control" id="phone_2" name="phone_2"
                   value="{{ old('phone_2') ?? ($user->profile ? $user->profile->phone_2 : null ) }}">
        </div>
    </div>

    <hr class="mt-5">

    @if ($countries->count())
        <div class="form-group">
            <label for="countries">@lang('profile.select.country')</label>
            <select name="country" id="countries" class="form-control" onchange="getCities()">
                @if (!$user->profile)
                    <option value="" disabled selected>
                        @lang('profile.select.country')
                    </option>
                @elseif(!$user->profile->country)
                    <option value="" disabled selected>
                        @lang('profile.select.country')
                    </option>
                @endif
                @foreach($countries as $country)
                    <option value="{{ $country }}"
                            {{ $user->profile && $user->profile->country == $country ? 'selected' : '' }}>
                        {{ $country }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cities">@lang('profile.select.city')</label>
            <select name="city" id="cities" class="form-control"
                    {{ !$cities ? 'disabled' : '' }}>
                @forelse($cities as $city)
                    <option value="{{ $city }}"
                            {{ $user->profile && $user->profile->city == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                @empty
                    <option value="" selected>
                        @lang('profile.select.city')
                    </option>
                @endforelse
            </select>
        </div>
    @endif

    <div class="form-group">
        <label for="address">@lang('profile.select.address')</label>
        <textarea class="form-control" id="address"
                  name="address">{{ old('address') ?? ($user->profile ? $user->profile->address : null) }}</textarea>
    </div>

    <button class="btn btn-primary">Обновить</button>
</form>
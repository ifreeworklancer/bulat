@extends('layouts.app', ['page_title' => trans('pages.home.title')])

@section('breadcrumbs')
    <li>
        <span>
            @lang('profile.title')
        </span>
    </li>
@endsection

@section('content')

    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="list-group mb-3" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active"
                           id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                            @lang('navigation.profile.profile')
                        </a>
                        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" id="list-favorites-list" data-toggle="list" href="#list-favorites" role="tab" aria-controls="favorites">
                            @lang('navigation.profile.favorites')
                            <span class="badge badge-secondary badge-pill text-white">
                                {{ auth()->user()->favorites()->count() }}
                            </span>
                        </a>
                        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" id="list-applications-list" data-toggle="list" href="#list-applications" role="tab" aria-controls="applications">
                            @lang('navigation.profile.applications')
                            <span class="badge badge-secondary badge-pill text-white">
                                {{ auth()->user()->applications()->count() }}
                            </span>
                        </a>
                        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" id="list-history-list" data-toggle="list" href="#list-history" role="tab" aria-controls="history">
                            @lang('navigation.profile.history')
                            <span class="badge badge-secondary badge-pill text-white">
                                {{ auth()->user()->orders()->count() }}
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                            @include('partials.app.profile.user')
                        </div>
                        <div class="tab-pane fade" id="list-favorites" role="tabpanel" aria-labelledby="list-favorites-list">
                            @include('partials.app.profile.favorites')
                        </div>
                        <div class="tab-pane fade" id="list-applications" role="tabpanel" aria-labelledby="list-applications-list">
                            @include('partials.app.profile.applications')
                        </div>
                        <div class="tab-pane fade" id="list-history" role="tabpanel" aria-labelledby="list-history-list">
                            @include('partials.app.profile.orders')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
      function getCities() {
        const citySelector = document.getElementById('cities');
        axios.post('{{ route('app.profile.cities') }}', {country: event.target.value})
          .then(function (response) {
            citySelector.innerHTML = '';
            citySelector.removeAttribute('disabled');

            response.data.cities.forEach(function ($city) {
              const el = document.createElement('option');
              el.value = $city;
              el.innerText = $city;
              citySelector.appendChild(el);
            });
          });
      }
    </script>
@endpush
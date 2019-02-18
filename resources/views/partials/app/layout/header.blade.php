<header id="app-header" class="{{ $header_class ?? '' }}">
    <div class="container-fluid container-fluid--header">
        <div class="d-flex">
            <div class="navbar navbar--left flex-nowrap">
                <nav class="nav align-items-center flex-nowrap">
                    <a href="{{ url('/') }}" class="nav-link nav-link--logo d-lg-none">
                        <svg width="40" height="40">
                            <use xlink:href="#helmet"></use>
                        </svg>
                    </a>

                    <ul class="menu">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link nav-link--logo">
                                <svg width="40" height="40">
                                    <use xlink:href="#helmet"></use>
                                </svg>
                            </a>
                        </li>

                        @foreach(app('nav')->frontend() as $item)
                            <li class="nav-item">
                                <a href="{{ $item->route }}" class="nav-link">
                                    {!! $item->name !!}
                                </a>
                            </li>
                        @endforeach

                        <li class="d-lg-none menu-close" data-menu-close>
                            <i class="material-icons">close</i>
                        </li>
                    </ul>

                    <div class="d-lg-none pl-3">
                        <a href="#menu" class="material-icons menu-toggle" data-menu>menu</a>
                    </div>

                    <form action="{{ route('app.search') }}" class="search">
                        <button class="btn btn-search material-icons">search</button>
                        <input type="text" name="q" autocomplete="none" class="form-control form-control--global-search"
                               placeholder="{{ trans('pages.catalog.search.placeholder') }}" required>
                    </form>
                </nav>

                <a href="#search" class="material-icons nav-link" data-search>search</a>

                @if (!in_array(app('router')->currentRouteName(), ['app.home', 'login', 'register', 'password.request', 'password.reset']))
                    <ul class="breadcrumbs list-unstyled d-none d-lg-flex">
                        <li itemprop="itemListElement">
                            <a href="{{ route('app.home') }}" class="text-dark">
                                @lang('pages.home.title')
                            </a>
                        </li>
                        <li class="breadcrumbs-separator">/</li>
                        @yield('breadcrumbs')
                    </ul>
                @endif
            </div>

            <div class="navbar navbar--right ml-auto text-right ">
                @auth
                    @if (!auth()->user()->hasRole('admin'))
                        <a href="{{ route('app.profile.index') }}">
                            @lang('profile.title')
                        </a>
                    @else
                        <a href="{{ route('admin.home') }}">
                            @lang('navigation.header.dashboard')
                        </a>
                    @endif
                @else
                    <div class="d-flex">
                        <a href="{{ route('login') }}" class="mr-3">
                            @lang('profile.login')
                        </a>
                        <a href="{{ route('register') }}">
                            @lang('profile.register')
                        </a>
                    </div>
                @endauth
                {{--
                <div class="locale-selector mt-1 ml-auto ml-lg-3 mt-lg-0">
                    @foreach(config('app.locales') as $locale)
                        @if (app()->getLocale() === $locale)
                            <span class="locale-selector__item is-active">{{ $locale }}</span>
                        @else
                            <a href="{{ route('app.locale', [$locale]) }}"
                               class="locale-selector__item">{{ $locale }}</a>
                        @endif
                    @endforeach
                </div>
                --}}
            </div>
        </div>
    </div>
</header>
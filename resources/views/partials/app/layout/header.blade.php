<header id="app-header" class="{{ $header_class ?? '' }}">
    <div class="container-fluid container-fluid--header">
        <div class="d-flex">
            <div class="navbar navbar--left">
                <nav class="nav">
                    @foreach(app('nav')->frontend() as $item)
                        <a href="{{ $item->route }}" class="nav-link">
                            {{ $item->name }}
                        </a>
                    @endforeach
                </nav>

                @if (!in_array(app('router')->currentRouteName(), ['app.home', 'login', 'register', 'password.request', 'password.reset']))
                    <ul class="breadcrumbs list-unstyled d-flex">
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
            <div class="navbar navbar--right ml-auto">
                @auth
                    <a href="{{ route('app.profile.index') }}">
                        @lang('profile.title')
                    </a>
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
                <div class="locale-selector ml-3">
                    @foreach(config('app.locales') as $locale)
                        @if (app()->getLocale() === $locale)
                            <span class="locale-selector__item is-active">{{ $locale }}</span>
                        @else
                            <a href="{{ route('app.locale', [$locale]) }}"
                               class="locale-selector__item">{{ $locale }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</header>
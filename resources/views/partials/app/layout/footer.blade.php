<footer id="app-footer">
    <div class="container">
        <div class="d-flex align-items-center footer-info">
            <div class="footer-logo pr-5">
                <a href="{{ url('/') }}" class="nav-link nav-link--logo">
                    <svg width="160" height="160">
                        <use xlink:href="#helmet"></use>
                    </svg>
                </a>
            </div>

            <div class="flex-grow-1">
                <nav class="row font-weight-bold mb-5">
                    @foreach(app('nav')->frontend() as $item)
                        <div class="col">
                            <a href="{{ $item->route }}">
                                {{ $item->name }}
                            </a>
                        </div>
                    @endforeach
                </nav>

                <form action="" method="post" class="subscription-form">
                    <p class="mb-0"><strong>@lang('common.footer.subscription.title')</strong></p>

                    <label for="subscription">@lang('common.footer.subscription.label')</label>
                    <div class="form-group mb-0 d-flex">
                        <input type="email" class="form-control">
                        <button class="btn btn-primary">@lang('common.footer.subscription.button')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="copyrights py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md">&copy; {{ date('Y') }} @lang('common.footer.copyright')</div>
                <div class="col-md"></div>
                <div class="col-md">
                    @lang('common.footer.developer')
                    <a href="https://impressionbureau.pro" class="nowrap text-secondary" target="_blank">
                        Impression.Bureau
                    </a>
                    <sup>2019</sup>
                </div>
            </div>
        </div>
    </div>
</footer>
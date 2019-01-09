<footer id="app-footer">
    <div class="container">
        <div class="d-flex">
            <div class="footer-logo pr-3"></div>

            <div class="footer-info flex-grow-1">
                <nav class="row font-weight-bold mb-5">
                    @foreach(app('nav')->frontend() as $item)
                        <div class="col">
                            <a href="{{ $item->route }}">
                                {{ $item->name }}
                            </a>
                        </div>
                    @endforeach
                </nav>

                <form action="" method="post" class="subscription-form mx-auto">
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
                </div>
            </div>
        </div>
    </div>
</footer>
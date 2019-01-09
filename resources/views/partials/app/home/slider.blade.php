<section id="home-slider" class="p-0">
    <div class="slider">
        @foreach($slides as $slide)
            <div class="slide{{ $slide->has_background ? ' slide--has-background' : '' }}"
                 style="background: url({{ $slide->banner }}) 50% 50% / cover no-repeat;">
                <div class="slide__entry">
                    <h2 class="h3 mb-2 text-uppercase">{{ $slide->translate('title') }}</h2>
                    <p class="mb-0 ml-4">{{ $slide->translate('description') }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="slider-nav mx-auto">
        <div class="slider-nav-arrow" data-direction="previous">
            <i class="material-icons">
                keyboard_arrow_left
            </i>
        </div>
        <ul class="slider-nav-dots">
            @foreach($slides as $slide)
                <li class="text-center slider-nav-dot {{ $loop->index === 0 ? 'is-active' : '' }}">
                    <span>{{ sprintf('%02d', $loop->iteration) }}</span>
                </li>
            @endforeach
        </ul>
        <div class="slider-nav-arrow" data-direction="next">
            <i class="material-icons">
                keyboard_arrow_right
            </i>
        </div>
    </div>
</section>
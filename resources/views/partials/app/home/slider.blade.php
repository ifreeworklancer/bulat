<section id="home-slider" class="p-0">
    <div class="slider">
        @foreach($slides as $slide)
            <figure class="lozad slide m-0{{ $slide->has_background ? ' slide--has-background' : '' }}"
                 data-background-image="{{ $slide->banner }}"></figure>
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
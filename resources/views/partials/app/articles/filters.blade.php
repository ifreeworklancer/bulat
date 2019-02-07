<div class="row mb-4 collapse{{ request()->has('tags') ? ' show' : '' }}" id="filters">
    @foreach($groups as $group)
        <div class="col-sm">
            <h6 class="mb-2 nowrap">
                {{ $group->title }}
            </h6>

            <ul class="list-unstyled smaller">
                @foreach($group->tags as $tag)
                    <li>
                        <a href="{{ $tag->query_filter }}"
                           class="d-inline-flex align-items-center">
                            <i class="material-icons mr-2">
                                @if (request()->has('tags') && in_array($tag->slug, explode(',',request()->get('tags'))))
                                    check_box
                                @else
                                    check_box_outline_blank
                                @endif
                            </i>
                            {{ $tag->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
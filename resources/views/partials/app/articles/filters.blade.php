<div class="row mb-4 collapse{{ request()->has('tags') ? ' show' : '' }}" id="filters">
    @foreach($tags as $key => $group)
        <div class="col-sm">
            <h6 class="mb-2 nowrap">
                {{ $groups->find($key)->translate('title') }}
            </h6>

            <ul class="list-unstyled smaller" id="group-{{ $key }}">
                @foreach($group as $tag)
                    <li>
                        @if (request()->has('tags') && in_array($tag->id, explode(',',request()->get('tags'))))
                            <a href="{{ urldecode(route('app.articles.index', $tag->removeFromQueryFilter())) }}"
                               class="d-inline-flex align-items-center">
                                <i class="material-icons mr-2">check_box</i>
                                <s>{{ $tag->translate('title') }}</s>
                            </a>
                        @else
                            <a href="{{ urldecode(route('app.articles.index', $tag->buildQueryFilter())) }}"
                               class="d-inline-flex align-items-center">
                                <i class="material-icons mr-2">
                                    check_box_outline_blank
                                </i>
                                {{ $tag->translate('title') }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
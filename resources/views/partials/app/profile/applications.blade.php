<div class="row applications">
    @forelse(auth()->user()->applications as $application)
        <div class="col">
            <article class="py-3 px-4 bg-light small text-primary d-inline-flex">
                <table class="table table-sm table-borderless mb-0 w-auto">
                    <tr>
                        <td width="100"><strong>ID</strong></td>
                        <td>{{ $application->id }}</td>
                    </tr>
                    <tr>
                        <td>
                            <strong>@lang('profile.applications.created_at')</strong>
                        </td>
                        <td>
                            {{ $application->created_at->formatLocalized('%d %B %Y, %H:%M') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>@lang('profile.applications.status')</strong>
                        </td>
                        <td class="text-{{ $application->status == 'confirmed' ? 'success' : ($application->status == 'declined' ? 'danger' : 'primary') }}">
                            @lang('profile.applications.statuses.' . $application->status)
                        </td>
                    </tr>
                </table>
            </article>
        </div>
    @empty
    @endforelse
</div>
@if ($links->count())

    <table class="table table-bordered align-middle">

        <thead>
            <tr>
                <th>Original URL</th>
                <th>Short URL</th>
                <th>Hits</th>
                @if (auth()->user()->isSuperAdmin())
                    <th>Company</th>
                @endif
                @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                    <th>Created by</th>
                @endif
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($links as $link)
                <tr>
                    <td class="link-original-url">{{ $link->original_url }}</td>
                    <td>{{ $link->short_url }}</td>
                    <td>{{ $link->hits_count }}</td>
                    @if (auth()->user()->isSuperAdmin())
                        <td>{{ $link->user->company->name }}</td>
                    @endif
                    @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <td>
                            {{ $link->user->name }}
                            @if ($link->user->role === 'admin')
                                <span class="badge bg-primary me-1">Admin</span>
                            @elseif ($link->user->role === 'member')
                                <span class="badge bg-warning me-1">Member</span>
                            @endif
                        </td>
                    @endif
                    <td>{{ $link->created_at->format('d M, Y') }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{-- Pagination footer --}}

    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing
            <strong>{{ $links->firstItem() }}</strong>
            -
            <strong>{{ $links->lastItem() }}</strong>
            of
            <strong>{{ $links->total() }}</strong>
        </div>

        <nav>
            <ul class="pagination mb-0">

                {{-- PREV --}}

                <li class="page-item {{ $links->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" href="{{ $links->previousPageUrl() }}">
                        Prev
                    </a>
                </li>

                {{-- PAGES --}}

                @foreach ($links->getUrlRange(1, $links->lastPage()) as $page => $url)
                    <li class="page-item {{ $links->currentPage() === $page ? 'active' : '' }}">
                        <a class="page-link pagination-link" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- NEXT --}}

                <li class="page-item {{ !$links->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" href="{{ $links->nextPageUrl() }}">
                        Next
                    </a>
                </li>

            </ul>

        </nav>

    </div>

@else
    <div class="alert alert-info">
        No Links found.
    </div>
@endif

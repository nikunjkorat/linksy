@if ($users->count())

    <table class="table table-bordered align-middle">

        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Total Generated URLs</th>
                <th>Total URL Hits</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr data-uid="{{ $user->uid }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->role === 'admin')
                            <span class="badge bg-primary me-1">Admin</span>
                        @elseif ($user->role === 'member')
                            <span class="badge bg-warning me-1">Member</span>
                        @endif

                    </td>
                    <td>{{ $user->total_generated_urls ?? '-' }}</td>
                    <td>{{ $user->total_url_hits ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{-- Pagination footer --}}

    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing
            <strong>{{ $users->firstItem() }}</strong>
            -
            <strong>{{ $users->lastItem() }}</strong>
            of
            <strong>{{ $users->total() }}</strong>
        </div>

        <nav>
            <ul class="pagination mb-0">

                {{-- PREV --}}

                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="active-users" href="{{ $users->previousPageUrl() }}">
                        Prev
                    </a>
                </li>

                {{-- PAGES --}}

                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <li class="page-item {{ $users->currentPage() === $page ? 'active' : '' }}">
                        <a class="page-link pagination-link" data-table="active-users" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- NEXT --}}

                <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="active-users" href="{{ $users->nextPageUrl() }}">
                        Next
                    </a>
                </li>

            </ul>

        </nav>

    </div>

@else
    <div class="alert alert-info">
        No users found.
    </div>
@endif

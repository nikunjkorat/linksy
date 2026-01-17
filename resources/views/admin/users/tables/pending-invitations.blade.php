@if ($pendingInvitations->count())

    <table class="table table-bordered align-middle">

        <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Invited At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingInvitations as $invitation)
                <tr>
                    <td>{{ $invitation->email }}</td>
                    <td>
                        @if ($invitation->role === 'admin')
                            <span class="badge bg-primary me-1">Admin</span>
                        @elseif ($invitation->role === 'member')
                            <span class="badge bg-warning me-1">Member</span>
                        @endif

                    </td>
                    <td><span class="badge bg-danger me-1">Pending</span></td>
                    <td>{{ $invitation->created_at->format('d M, Y') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{-- Pagination footer --}}

    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing
            <strong>{{ $pendingInvitations->firstItem() }}</strong>
            -
            <strong>{{ $pendingInvitations->lastItem() }}</strong>
            of
            <strong>{{ $pendingInvitations->total() }}</strong>
        </div>

        <nav>
            <ul class="pagination mb-0">

                {{-- PREV --}}

                <li class="page-item {{ $pendingInvitations->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="pending-invitations" href="{{ $pendingInvitations->previousPageUrl() }}">
                        Prev
                    </a>
                </li>

                {{-- PAGES --}}

                @foreach ($pendingInvitations->getUrlRange(1, $pendingInvitations->lastPage()) as $page => $url)
                    <li class="page-item {{ $pendingInvitations->currentPage() === $page ? 'active' : '' }}">
                        <a class="page-link pagination-link" data-table="pending-invitations" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- NEXT --}}

                <li class="page-item {{ !$pendingInvitations->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="pending-invitations" href="{{ $pendingInvitations->nextPageUrl() }}">
                        Next
                    </a>
                </li>

            </ul>

        </nav>

    </div>

@else
    <div class="alert alert-info">
        No pending invitations found.
    </div>
@endif

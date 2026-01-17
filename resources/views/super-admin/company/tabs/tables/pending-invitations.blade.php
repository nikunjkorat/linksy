@if ($pendingInvites->count())

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingInvites as $invite)
                <tr id="invite-row-{{ $invite->id }}">
                    <td>{{ $invite->email }}</td>
                    <td>
                        @if ($invite->role === 'admin')
                            <span class="badge bg-primary me-1">
                                Admin
                            </span>
                        @elseif ($invite->role === 'member')
                            <span class="badge bg-warning me-1">
                                Member
                            </span>
                        @endif

                    </td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">

        <div class="text-muted small">
            Showing
            <strong>{{ $pendingInvites->firstItem() }}</strong>
            -
            <strong>{{ $pendingInvites->lastItem() }}</strong>
            of
            <strong>{{ $pendingInvites->total() }}</strong>
        </div>

        <nav>

            <ul class="pagination mb-0">

                {{-- PREV --}}

                <li class="page-item {{ $pendingInvites->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="pending-invitations"
                        href="{{ $pendingInvites->previousPageUrl() }}">
                        Prev
                    </a>
                </li>

                {{-- PAGES --}}

                @foreach ($pendingInvites->getUrlRange(1, $pendingInvites->lastPage()) as $page => $url)
                    <li class="page-item {{ $pendingInvites->currentPage() === $page ? 'active' : '' }}">
                        <a class="page-link pagination-link" data-table="pending-invitations"
                            href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- NEXT --}}

                <li class="page-item {{ $pendingInvites->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link pagination-link" data-table="pending-invitations"
                        href="{{ $pendingInvites->nextPageUrl() }}">
                        Next
                    </a>
                </li>

            </ul>

        </nav>

    </div>

@else
    <div class="p-3 text-muted">
        No pending invitations.
    </div>
@endif

@if ($members->count())

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td>{{ $member->email }}</td>
                    <td>
                        <span class="badge bg-warning">
                            {{ ucfirst($member->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success">
                            Active
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing
            <strong>{{ $members->firstItem() }}</strong>
            -
            <strong>{{ $members->lastItem() }}</strong>
            of
            <strong>{{ $members->total() }}</strong>
        </div>

        <nav>
            <ul class="pagination mb-0">

                {{-- PREV --}}

                <li class="page-item {{ $members->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="members" href="{{ $members->previousPageUrl() }}">
                        Prev
                    </a>
                </li>

                {{-- PAGES --}}

                @foreach ($members->getUrlRange(1, $members->lastPage()) as $page => $url)
                    <li class="page-item {{ $members->currentPage() === $page ? 'active' : '' }}">
                        <a class="page-link pagination-link" data-table="members" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- NEXT --}}

                <li class="page-item {{ !$members->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="members" href="{{ $members->nextPageUrl() }}">
                        Next
                    </a>
                </li>

            </ul>

        </nav>

    </div>

@else
    <div class="p-3 text-muted">
        No members assigned yet.
    </div>
@endif

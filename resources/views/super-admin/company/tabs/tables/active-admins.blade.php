@if ($admins->count())

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <span class="badge bg-primary">
                            {{ ucfirst($admin->role) }}
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
            <strong>{{ $admins->firstItem() }}</strong>
            -
            <strong>{{ $admins->lastItem() }}</strong>
            of
            <strong>{{ $admins->total() }}</strong>
        </div>

        <nav>
            <ul class="pagination mb-0">

                {{-- PREV --}}

                <li class="page-item {{ $admins->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="admins" href="{{ $admins->previousPageUrl() }}">
                        Prev
                    </a>
                </li>

                {{-- PAGES --}}

                @foreach ($admins->getUrlRange(1, $admins->lastPage()) as $page => $url)
                    <li class="page-item {{ $admins->currentPage() === $page ? 'active' : '' }}">
                        <a class="page-link pagination-link" data-table="admins" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- NEXT --}}

                <li class="page-item {{ !$admins->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" data-table="admins" href="{{ $admins->nextPageUrl() }}">
                        Next
                    </a>
                </li>

            </ul>

        </nav>

    </div>

@else
    <div class="p-3 text-muted">
        No admins assigned yet.
    </div>
@endif

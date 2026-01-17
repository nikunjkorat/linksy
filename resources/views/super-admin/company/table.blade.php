@if ($companies->count())

    <table class="table table-bordered align-middle">

        <thead>
            <tr>
                <th>Name</th>
                <th>Users</th>
                <th>Total Generated URLs</th>
                <th>Total URL Hits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr data-uid="{{ $company->uid }}">
                    <td class="company-name">{{ $company->name }}</td>
                    <td>{{ $company->users_count }}</td>
                    <td>{{ $company->short_urls_count ?: 0 }}</td>
                    <td>{{ $company->total_url_hits ?: 0 }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-company">Edit</button>
                        <button class="btn btn-sm btn-danger delete-company">Delete</button>
                        <a href="{{ route('superadmin.companies.overview.index', $company) }}"
                            class="btn btn-sm btn-info show-company">Show</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{-- Pagination footer --}}

    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing
            <strong>{{ $companies->firstItem() }}</strong>
            -
            <strong>{{ $companies->lastItem() }}</strong>
            of
            <strong>{{ $companies->total() }}</strong>
        </div>

        <nav>
            <ul class="pagination mb-0">

                {{-- PREV --}}

                <li class="page-item {{ $companies->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" href="{{ $companies->previousPageUrl() }}">
                        Prev
                    </a>
                </li>

                {{-- PAGES --}}

                @foreach ($companies->getUrlRange(1, $companies->lastPage()) as $page => $url)
                    <li class="page-item {{ $companies->currentPage() === $page ? 'active' : '' }}">
                        <a class="page-link pagination-link" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- NEXT --}}

                <li class="page-item {{ !$companies->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link pagination-link" href="{{ $companies->nextPageUrl() }}">
                        Next
                    </a>
                </li>

            </ul>

        </nav>

    </div>
@else
    <div class="alert alert-info">
        No companies found.
    </div>
@endif

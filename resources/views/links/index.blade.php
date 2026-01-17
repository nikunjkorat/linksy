@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3 mb-3">
            <h3>Generated Links</h3>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <select class="form-select" id="filterDate" data-default="all">
                    <option value="all" selected>All</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>

                @if (auth()->user()->isAdmin() || auth()->user()->isMember())
                    <button class="btn btn-primary flex-shrink-0" id="createShortUrlBtn">
                        + Create Short URL
                    </button>
                @endif

            </div>
        </div>

        <div id="linkListing" class="tableWrapper">
            @include('links.table', ['links' => $links])
        </div>

    </div>

    @include('modals.create-link')
@endsection

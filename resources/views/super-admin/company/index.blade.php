@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h3>Companies</h3>
            <button class="btn btn-primary" id="createCompanyBtn">
                + Create Company
            </button>
        </div>

        <div id="companiesTableWrapper">
            @include('super-admin.company.table', ['companies' => $companies])
        </div>

    </div>

    @include('super-admin.company.modals.create')
    @include('super-admin.company.modals.delete')
@endsection

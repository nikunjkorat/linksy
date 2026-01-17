@extends('super-admin.company.show')

@section('company-tab')
    {{-- Action Bar --}}

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Company Users</h5>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inviteAdminModal">
            + Invite Admin
        </button>
    </div>

    <hr />

    {{-- Active Admins --}}

    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h4>Active Admins</h4>
        </div>

        <div class="tableWrapper">
            @include('super-admin.company.tabs.tables.active-admins', ['admins' => $admins])
        </div>

    </div>

    {{-- Active Members --}}

    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h4>Active Members</h4>
        </div>

        <div class="tableWrapper">
            @include('super-admin.company.tabs.tables.active-members', ['members' => $members])
        </div>

    </div>

    {{-- Pending Invitations --}}

    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h4>Pending Invitations</h4>
        </div>

        <div class="tableWrapper">
            @include('super-admin.company.tabs.tables.pending-invitations', [
                'pendingInvites' => $pendingInvites,
            ])
        </div>

    </div>
@endsection

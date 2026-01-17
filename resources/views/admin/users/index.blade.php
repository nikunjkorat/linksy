@extends('layouts.app')

@section('content')

    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h3>Team Users</h3>
            <button class="btn btn-primary" id="inviteUserBtn" data-bs-toggle="modal"
            data-bs-target="#inviteUserModal">
                + Invite User
            </button>
        </div>

        <div class="tableWrapper">
            @include('admin.users.tables.active-users', ['users' => $users])
        </div>

    </div>

    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h3>Pending Invitations</h3>
        </div>

        <div class="tableWrapper">
            @include('admin.users.tables.pending-invitations', ['pendingInvitations' => $pendingInvitations])
        </div>

    </div>

    @include('admin.users.modals.invite-user')
@endsection

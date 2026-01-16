@extends('super-admin.company.show')

@section('company-tab')

{{-- Action Bar --}}

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Company Admins</h5>

    <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#inviteAdminModal">
        + Invite Admin
    </button>
</div>

{{-- Active Admins --}}

<div class="card mb-4">

    <div class="card-header">
        Active Admins
    </div>

    <div class="card-body p-0">
        @if($admins->count())
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <span class="badge bg-secondary">
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
        @else
            <div class="p-3 text-muted">
                No admins assigned yet.
            </div>
        @endif
    </div>
</div>

{{-- Pending Invitations --}}

<div class="card">
    <div class="card-header">
        Pending Invitations
    </div>

    <div class="card-body p-0">
        @if($pendingInvites->count())
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingInvites as $invite)
                        <tr id="invite-row-{{ $invite->id }}">
                            <td>{{ $invite->email }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ ucfirst($invite->role) }}
                                </span>
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
        @else
            <div class="p-3 text-muted">
                No pending invitations.
            </div>
        @endif
    </div>
</div>

@endsection

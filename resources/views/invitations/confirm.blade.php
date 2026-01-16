@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-body text-center">

                    <h4 class="mb-3">
                        Accept Invitation
                    </h4>

                    <p>
                        You've been invited to join
                        <strong>{{ $invite->company->name }}</strong>
                        as an <strong>Admin</strong>.
                    </p>

                    <form id="acceptInviteForm" method="POST" action="{{ route('invitations.accept', $token) }}">
                        @csrf
                        <button class="btn btn-primary w-100" type="submit">
                            Accept Invitation
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

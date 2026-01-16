@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 text-center">
                        Set your password
                    </h4>

                    <p class="text-center text-muted">
                        Create a password to manage
                        <strong>{{ $invite->company->name }}</strong>.
                    </p>

                    <form id="setPasswordForm" method="POST"
                          action="{{ route('invitations.complete', $token) }}">
                        @csrf

                        <div class="mb-3">
                            <label>Name</label>
                            <input name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Create Account & Continue
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

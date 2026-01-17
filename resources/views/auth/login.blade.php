@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4 text-center fw-bold">Login to Linksy</h4>

                    <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="alert alert-danger mt-3 d-none" id="loginError"></div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" placeholder="Enter email address" class="form-control">
                            <div class="invalid-feedback" data-error="email"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" placeholder="********" name="password" class="form-control">
                            <div class="invalid-feedback" data-error="password"></div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="loginBtn">
                                Login
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

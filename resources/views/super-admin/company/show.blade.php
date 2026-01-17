@extends('layouts.app')

@section('content')

    <div class="container py-2">

        {{-- Header --}}

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex flex-row align-items-center">
                <a href="{{ route('superadmin.companies.index') }}" class="btn btn-link">
                    <svg width="38px" height="38px" viewBox="0 0 1024.00 1024.00" xmlns="http://www.w3.org/2000/svg"
                        fill="#212529" stroke="#212529" stroke-width="26.624000000000002">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill="#212529" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                            <path fill="#212529"
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z">
                            </path>
                        </g>
                    </svg>
                </a>
                <h4 class="mb-0">{{ $company->name }}</h4>
                <small class="text-muted">{{ $company->slug }}</small>
            </div>
        </div>

        {{-- Tabs --}}

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('superadmin.companies.overview.*') ? 'active' : '' }}"
                    href="{{ route('superadmin.companies.overview.index', $company) }}">
                    Overview
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('superadmin.companies.admins.*') ? 'active' : '' }}"
                    href="{{ route('superadmin.companies.admins.index', $company) }}">
                    Users
                </a>
            </li>

        </ul>

        {{-- Tab Content --}}

        @yield('company-tab')

    </div>

    @include('super-admin.company.modals.invite-admin')
@endsection

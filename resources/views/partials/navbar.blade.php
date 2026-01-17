<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        {{-- Brand --}}

        <a class="navbar-brand fw-bold" href="{{ route('landing') }}">
            🔗 Linksy
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Guest --}}

                @guest

                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#faqs">FAQs</a>
                    </li>

                @endguest

                {{-- Authenticated User --}}

                @auth

                    {{-- Dashboard (role aware) --}}

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs(Auth::user()->dashboardRoute()) ? 'active fw-semibold' : '' }}"
                            href="{{ route(Auth::user()->dashboardRoute()) }}">
                            Dashboard
                        </a>
                    </li>

                    {{-- Super Admin Links --}}

                    @if (auth()->user()?->isSuperAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('superadmin.companies.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('superadmin.companies.index') }}">
                                Companies
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('superadmin.links.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('superadmin.links.index') }}">
                                Links
                            </a>
                        </li>
                    @endif

                    {{-- Admin --}}

                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.links.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.links.index') }}">
                                Links
                            </a>
                        </li>
                    @endif

                    {{-- Member --}}

                    @if (auth()->user()->isMember())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.links.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('member.links.index') }}">
                                Links
                            </a>
                        </li>
                    @endif

                @endauth

            </ul>

            {{-- Right Nav --}}

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Login
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

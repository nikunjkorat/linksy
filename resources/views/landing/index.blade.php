@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-5 fw-bold">
                    Short Links.<br>
                    <span class="text-warning">Big Control.</span>
                </h1>
                <p class="lead mt-3">
                    Linksy helps companies and teams generate, manage, and track short URLs
                    with proper access control and security.
                </p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg me-2">
                        Get Started
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg">
                        Learn More
                    </a>
                </div>
            </div>

            <div class="col-lg-6 text-center">
                <img src="https://dummyimage.com/500x350/ffffff/000000&text=Linksy+Dashboard"
                     alt="Linksy dashboard preview"
                     class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section id="features" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose Linksy?</h2>
            <p class="text-muted mt-2">
                Built for companies, not just individuals.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Multi-Company</h5>
                        <p class="card-text text-muted">
                            Manage multiple companies with strict data isolation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Role Based Access</h5>
                        <p class="card-text text-muted">
                            SuperAdmin, Admin, and Member roles with clear boundaries.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Secure Invitations</h5>
                        <p class="card-text text-muted">
                            Invite users safely with token-based invitations.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Fast Redirects</h5>
                        <p class="card-text text-muted">
                            Public short links that resolve instantly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQs --}}
<section id="faqs" class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
        </div>

        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        Is Linksy free to use?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        Linksy is an assessment project showcasing secure URL shortening with role-based access.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Who can create short URLs?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Admins and Members can create short URLs based on their permissions.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Are short URLs public?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Yes. Anyone can access them, but only authorized users can manage them.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

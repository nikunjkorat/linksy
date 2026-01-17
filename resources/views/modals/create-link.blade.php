@php

$URL = route('member.links.store');

if(auth()->user()->isAdmin()) {
    $URL = route('admin.links.store');
}
    
@endphp

<div class="modal fade" id="createShortUrlModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Short URL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="createShortUrlForm" method="POST" action="{{ $URL }}">
                @csrf

                <div class="modal-body">

                    <div class="alert alert-danger d-none" id="createUrlError"></div>

                    <div class="mb-3">
                        <label class="form-label">Original URL</label>
                        <input
                            type="url"
                            name="original_url"
                            class="form-control"
                            placeholder="https://example.com/page"
                            required
                        >
                        <div class="invalid-feedback"></div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary" id="createUrlSubmit">
                        Create
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

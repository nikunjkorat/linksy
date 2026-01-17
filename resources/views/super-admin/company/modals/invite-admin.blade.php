<div class="modal fade" id="inviteAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Invite Admin to {{ $company->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
                id="inviteAdminForm"
                action="{{ route('superadmin.companies.admins.invite', $company) }}"
                method="POST"
            >
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Admin Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter admin name"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Admin Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter admin email"
                               required>
                    </div>

                    <small class="text-muted">
                        An invitation email will be sent to this address.
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Send Invitation
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

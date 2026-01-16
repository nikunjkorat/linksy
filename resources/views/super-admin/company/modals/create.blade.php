<div class="modal fade" id="companyModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="companyForm">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" id="companyId">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="companyModalLabel">Create Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="name" class="form-control">
                        <div class="invalid-feedback" data-error="name"></div>
                    </div>

                    <div id="adminInviteSection">

                        <div class="mb-3">
                            <label class="form-label">Admin Email</label>
                            <input type="email" name="admin_email" id="admin_email" class="form-control">
                            <div class="invalid-feedback" data-error="admin_email"></div>
                        </div>

                        <label>
                            <input type="checkbox" name="skip_invite" id="skip_invite" class="form-check-input">
                            Invite admin later
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="companySubmitBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

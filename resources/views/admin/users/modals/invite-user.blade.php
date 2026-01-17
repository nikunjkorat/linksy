<div class="modal fade" id="inviteUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.invitations.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Invite User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email address"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">Select Role</option>
                        <option value="member">Member</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    Send Invitation
                </button>
            </div>
        </form>
    </div>
</div>

// Company Management JS

// Initialize Bootstrap Modals

const modalEl = document.getElementById('companyModal');

let companyModal = null;

if(modalEl){
    companyModal = new bootstrap.Modal(modalEl);
}

const deleteModalEl = document.getElementById('deleteCompanyModal');

let deleteModal = null;

if(deleteModalEl){
    deleteModal = new bootstrap.Modal(deleteModalEl);
}

let currentCompanyUid = null;

// Company Form Handling

const form = $(document).find("#companyForm");

// Reset Form

function resetForm() {
    form[0].reset();
    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");
    form.find('[name="_method"]').val('POST');
    currentCompanyUid = null;
}

// Set Create Mode

function setCreateMode() {

    currentCompanyUid = null;

    form.attr("action", "/superadmin/companies");
    form.find('[name="_method"]').val("POST");

    $(document).find(".companyModalLabel").text("Create Company");

    form.find('#adminInviteSection').show();

    toggleAdminInviteFields();

    companyModal.show();

}

// Create Company Button Click

$(document).on("click", "#createCompanyBtn", function (e) {
    resetForm();
    setCreateMode();
});

// Set Edit Mode

function setEditMode(uid, name) {

    currentCompanyUid = uid;

    form.attr("action", `/superadmin/companies/${uid}`);
    form.find('[name="_method"]').val("PUT");

    form.find('[name="name"]').val(name);

    $(document).find(".companyModalLabel").text("Edit Company");

    form.find('#adminInviteSection').hide();

    companyModal.show();

}

// Edit Company Button Click

$(document).on("click", ".edit-company", function (e) {

    const row = $(this).closest("tr");

    const uid = row.data("uid");
    const name = row.find(".company-name").text();

    resetForm();
    setEditMode(uid, name);

});

// Company Create / Update Form Submission

form.on("submit", function (e) {

    e.preventDefault();

    const btn = form.find("#companySubmitBtn");

    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");

    btn.prop("disabled", true).text("Saving...");

    $.ajax({
        url: form.attr("action"),
        method: "POST",
        data: form.serialize(),
        success(response) {
            if(response.redirect) {
                window.location.href = response.redirect;
            }
        },
        error(xhr) {
            if (xhr.status === 422) {
                $.each(xhr.responseJSON.errors, function (field, messages) {
                    const input = form.find(`[name="${field}"]`);
                    input.addClass("is-invalid");
                    form.find(`[data-error="${field}"]`).text(messages[0]);
                });
            }
        },
        complete() {
            btn.prop("disabled", false).text("Save");
        },
    });
});

// Delete Company Handling

$(document).on('click', '.delete-company', function () {
    currentCompanyUid = $(this).closest('tr').data('uid');
    deleteModal.show();
});

// Confirm Delete Company

$(document).on('click', '#confirmDeleteCompany', function () {
    const btn = $(this);
    btn.prop('disabled', true).text('Deleting...');

    $.ajax({
        url: `/superadmin/companies/${currentCompanyUid}`,
        method: 'DELETE',
        data: form.serialize(),
        success(response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            }
        },
        complete() {
            btn.prop('disabled', false).text('Delete');
        }
    });
});

// Load Companies List

function loadTable(url, $this) {

    const $table = $this.closest('.tableWrapper');

    $table.addClass('opacity-50');

    $.ajax({
        url: url,
        method: 'GET',
        success(html) {
            $table.html(html);
        },
        complete() {
            $table.removeClass('opacity-50');
        }
    });
}

// Pagination click handler (delegated)

$(document).on('click', '.pagination-link', function (e) {

    e.preventDefault();

    const url = $(this).attr('href');
    if (!url) return;

    loadTable(url, $(this));

});

// Admin Invite Fields Toggle

function toggleAdminInviteFields() {

    const skip = $('#skip_invite').is(':checked');

    if (skip) {
        $('#admin_email, #admin_name')
            .val('')
            .prop('disabled', true)
            .removeClass('is-invalid');

        $('#adminEmailError').text('');
    } else {
        $('#admin_email, #admin_name').prop('disabled', false);
    }
}

// Bind once

$('#skip_invite').on('change', toggleAdminInviteFields);

const modalEl = document.getElementById('companyModal');
const companyModal = new bootstrap.Modal(modalEl);

const deleteModalEl = document.getElementById('deleteCompanyModal');
const deleteModal = new bootstrap.Modal(deleteModalEl);

let currentCompanyUid = null;

const form = $(document).find("#companyForm");

function resetForm() {
    form[0].reset();
    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");
    form.find('[name="_method"]').val('POST');
    currentCompanyUid = null;
}

function setCreateMode() {
    currentCompanyUid = null;

    form.attr("action", "/superadmin/companies");
    form.find('[name="_method"]').val("POST");

    $(document).find(".companyModalLabel").text("Create Company");

    companyModal.show();
}

$(document).on("click", "#createCompanyBtn", function (e) {
    resetForm();
    setCreateMode();
});

function setEditMode(uid, name) {
    currentCompanyUid = uid;

    form.attr("action", `/superadmin/companies/${uid}`);
    form.find('[name="_method"]').val("PUT");

    form.find('[name="name"]').val(name);

    $(document).find(".companyModalLabel").text("Edit Company");
}

$(document).on("click", ".edit-company", function (e) {
    const row = $(this).closest("tr");

    const uid = row.data("uid");
    const name = row.find(".company-name").text();

    resetForm();
    setEditMode(uid, name);

    companyModal.show();
});

form.on("submit", function (e) {
    e.preventDefault();

    const btn = $("#companySubmitBtn");

    btn.prop("disabled", true).text("Saving...");

    $.ajax({
        url: form.attr("action"),
        method: "POST", // Laravel will read _method
        data: form.serialize(),
        success(response) {
            companyModal.hide();
            loadCompanies(window.location.href);
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

$(document).on('click', '.delete-company', function () {
    currentCompanyUid = $(this).closest('tr').data('uid');
    deleteModal.show();
});

$(document).on('click', '#confirmDeleteCompany', function () {
    const btn = $(this);
    btn.prop('disabled', true).text('Deleting...');

    $.ajax({
        url: `/superadmin/companies/${currentCompanyUid}`,
        method: 'DELETE',
        data: form.serialize(),
        success(response) {
            deleteModal.hide();
            loadCompanies(window.location.href);

        },
        complete() {
            btn.prop('disabled', false).text('Delete');
        }
    });
});

function loadCompanies(url) {

    $('#companiesTableWrapper').addClass('opacity-50');

    $.ajax({
        url: url,
        method: 'GET',
        success(html) {
            $('#companiesTableWrapper').html(html);
        },
        complete() {
            $('#companiesTableWrapper').removeClass('opacity-50');
        }
    });
}

// Pagination click handler (delegated)

$(document).on('click', '.pagination-link', function (e) {

    e.preventDefault();

    const url = $(this).attr('href');
    if (!url) return;

    loadCompanies(url);
    
});

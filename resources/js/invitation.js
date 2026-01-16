// AJAX Invitation Form Submissions

// Accept Invitation Form

$(document).find('#acceptInviteForm').on('submit', function (e) {

    e.preventDefault();

    const form = $(this);

    const btn = form.find("button[type='submit']");

    btn.prop("disabled", true).text("Accepting...");

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success(response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            }
        },
        error(xhr) {
            handleAjaxError(xhr, form);
        },
        complete() {
            btn.prop("disabled", false).text("Accept Invitation");
        },
    });

});

// Set Password Form

$(document).find('#setPasswordForm').on('submit', function (e) {

    e.preventDefault();

    const form = $(this);

    const btn = form.find("button[type='submit']");

    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");

    btn.prop("disabled", true).text("Accepting...");

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success(response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            }
        },
        error(xhr) {
            handleAjaxError(xhr, form);
        },
        complete() {
            btn.prop("disabled", false).text("Accept Invitation");
        },
    });

});

// Invite Admin Form

$(document).find('#inviteAdminModal form').on('submit', function (e) {

    e.preventDefault();

    const form = $(this);

    const btn = form.find("button[type='submit']");

    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");

    btn.prop("disabled", true).text("Sending...");

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success(response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            }
        },
        error(xhr) {
            handleAjaxError(xhr, form);
        },
        complete() {
            btn.prop("disabled", false).text("Send Invitation");
        },
    });

});

// Common AJAX Error Handler

function handleAjaxError(xhr, form) {

    if (xhr.status === 422) {

        const errors = xhr.responseJSON.errors;

        $.each(errors, function (field, messages) {
            const input = form.find(`[name="${field}"]`);
            input.addClass('is-invalid');
            input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
        });

        return;
    }

}

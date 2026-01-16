$(document).find('#acceptInviteForm').on('submit', function (e) {

    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');
    const method = form.attr('method') || 'POST';

    const btn = $("#acceptInviteForm button[type='submit']");

    btn.prop("disabled", true).text("Accepting...");

    $.ajax({
        url: url,
        method: method,
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

$('#setPasswordForm').on('submit', function (e) {

    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');
    const method = form.attr('method') || 'POST';

    const btn = $("#setPasswordForm button[type='submit']");

    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");

    btn.prop("disabled", true).text("Accepting...");

    $.ajax({
        url: url,
        method: method,
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

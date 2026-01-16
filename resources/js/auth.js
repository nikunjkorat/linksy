// AJAX Login Form Submission

$(document).find('#loginForm').on('submit', function (e) {

    e.preventDefault();

    const form = $(this);
    const btn = form.find('#loginBtn');

    // Reset UI

    $('.invalid-feedback').text('');
    $('.form-control').removeClass('is-invalid');
    $('#loginError').addClass('d-none').text('');

    btn.prop('disabled', true).text('Logging in...');

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
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;

                $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    input.addClass('is-invalid');
                    $(`[data-error="${field}"]`).text(messages[0]);
                });
            }

            if (xhr.status === 401) {
                $('#loginError')
                    .removeClass('d-none')
                    .text(xhr.responseJSON.message);
            }
        },
        complete() {
            btn.prop('disabled', false).text('Login');
        }
    });
});

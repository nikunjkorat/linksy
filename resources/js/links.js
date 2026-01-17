// JavaScript code for handling the Create Short URL modal and AJAX form submission

const linkModalEl = document.getElementById("createShortUrlModal");

let createShortUrlModal = null;

if (linkModalEl) {
    createShortUrlModal = new bootstrap.Modal(linkModalEl);
}

// Create Short URL Form Handling

const form = $(document).find("#createShortUrlForm");

// Open Create Short URL Modal

$("#createShortUrlBtn").on("click", function () {
    form[0].reset();
    form.find("#createUrlError").addClass("d-none").html("");
    form.find(".is-invalid").removeClass("is-invalid");
    createShortUrlModal.show();
});

// Handle Create Short URL Form Submission

$(document)
    .find("#createShortUrlModal form")
    .on("submit", function (e) {
        e.preventDefault();

        const form = $(this);

        const btn = form.find("button[type='submit']");

        form.find(".invalid-feedback").text("");
        form.find(".form-control").removeClass("is-invalid");

        btn.prop("disabled", true).text("Sending...");

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: form.serialize(),
            success(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error(xhr) {
                handleCreateErrors(xhr);
            },
            complete() {
                btn.prop("disabled", false).text("Send Invitation");
            },
        });
    });

// Common AJAX Error Handler

function handleCreateErrors(xhr) {

    const res = xhr.responseJSON;

    $("#createUrlError").addClass("d-none").html("");
    $("#createShortUrlForm .is-invalid").removeClass("is-invalid");

    if (xhr.status === 422) {
        $.each(res.errors, function (field, messages) {
            const input = $(`[name="${field}"]`);
            input.addClass("is-invalid");
            input.next(".invalid-feedback").text(messages[0]);
        });
        return;
    }

    $("#createUrlError")
        .removeClass("d-none")
        .text(res?.message || "Something went wrong.");
}

// Link Listing with Filtering and Pagination

let currentFilter = $(document).find("#filterDate").data("default") || "all";

// Handle Filter Change

$(document).find("#filterDate").on("change", function () {
    currentFilter = $(this).val();
    loadLinks(1);
});

// Handle Pagination Clicks

$(document).on("click", "div#linkListing .pagination-link", function (e) {
    e.preventDefault();

    const page = new URL($(this).attr("href")).searchParams.get("page");
    loadLinks(page);
});

// Load Links with AJAX

function loadLinks(page = 1) {

    $.ajax({
        url: window.location.pathname,
        method: "GET",
        data: {
            filter: currentFilter,
            page: page,
        },
        success(response) {
            $(document).find("div#linkListing").html(response);
        },
    });

}

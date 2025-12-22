"use strict";

const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": CSRF_TOKEN
    }
});
let $savingLoader = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>',

    $ajaxform = $(".ajaxform");
$ajaxform.initFormValidation(),
    $(document).on("submit", ".ajaxform", function (e) {
        e.preventDefault();
        let t = $(this).find(".submit-btn"),
            a = t.html();
        $ajaxform.valid() &&
            $.ajax({
                type: "POST",
                url: this.action,
                data: new FormData(this),
                dataType: "json",
                contentType: !1,
                cache: !1,
                processData: !1,
                beforeSend: function () {
                    t.html($savingLoader).attr("disabled", !0);
                },
                success: function (e) {
                    t.html(a).removeClass("disabled").attr("disabled", !1);
                    if (e.redirect) {
                        window.sessionStorage.hasPreviousMessage = true;
                        window.sessionStorage.previousMessage =
                            e.message ?? null;
                        if (e.secondary_redirect_url) {
                            window.open(e.secondary_redirect_url, "_blank");
                        }
                        location.href = e.redirect;
                    } else {
                        Notify("success", null, e ?? 'Operation Successful.');
                    }
                },

                error: function (e) {
                    t.html(a).attr("disabled", !1), Notify("error", e);
                },
            });
    });

let $ajaxform_instant_reload = $(".ajaxform_instant_reload");
$ajaxform_instant_reload.initFormValidation(),
    $(document).on("submit", ".ajaxform_instant_reload", function (e) {
        e.preventDefault();
        let t = $(this).find(".submit-btn"),
            a = t.html();
        $ajaxform_instant_reload.valid() &&
            $.ajax({
                type: "POST",
                url: this.action,
                data: new FormData(this),
                dataType: "json",
                contentType: !1,
                cache: !1,
                processData: !1,
                positionClass: "toast-top-left",
                beforeSend: function () {
                    t.html($savingLoader).addClass("disabled").attr("disabled", !0);
                },
                success: function (e) {
                    t.html(a).removeClass("disabled").attr("disabled", !1), (window.sessionStorage.hasPreviousMessage = !0), (window.sessionStorage.previousMessage = e.message ?? null), e.redirect && (location.href = e.redirect);
                },
                error: function (e) {
                    t.html(a).removeClass("disabled").attr("disabled", !1), showInputErrors(e.responseJSON), Notify("error", e);
                },
            });
    });

// bulk product upload in cart
let $cartUploadform = $(".bulk_cart_upload_form");
$cartUploadform.initFormValidation();
$(document).on("submit", ".bulk_cart_upload_form", function (e) {
    e.preventDefault();

    let t = $(this).find(".submit-btn"),
        a = t.html();

    if (!$cartUploadform.valid()) return;

    $.ajax({
        type: "POST",
        url: this.action,
        data: new FormData(this),
        dataType: "json",

        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            t.html($savingLoader).attr("disabled", true);
        },
        success: function (response) {
            t.html(a).removeClass("disabled").attr("disabled", false);

            if (response.success) {
                fetchUpdatedCart(calTotalAmount);
                $("#bulk-upload-modal").modal("hide");
                $cartUploadform[0].reset();
                toastr.success(response.message);

            } else {
                toastr.error(response.message || "Some items failed to import.");
            }
        },
        error: function (xhr) {
            t.html(a).attr("disabled", false);

            // Show error from server response
            if (xhr.responseJSON && xhr.responseJSON.message) {
                toastr.error(xhr.responseJSON.message);
            } else if (xhr.responseText) {
                toastr.error(xhr.responseText);
            } else {
                toastr.error("Something went wrong.");
            }
        }
    });
});

// SALES PURCHASE FORM
let $sales_purchase_form = $(".sales_purchase_form");
$sales_purchase_form.initFormValidation();

$(document).on("submit", ".sales_purchase_form", function (e) {
    e.preventDefault();

    let $mainForm = $(this); // sales_purchase_form
    let $headerForm = $("form.sales-header-form"); // extra form to merge
    let $submitBtn = $mainForm.find(".submit-btn");
    let originalHtml = $submitBtn.html();

    if (!$mainForm.valid()) return;

    let formData = new FormData($mainForm[0]);
    let headerFormData = new FormData($headerForm[0]);

    // Merge second form fields
    for (let [key, value] of headerFormData.entries()) {
        formData.append(key, value);
    }

    $.ajax({
        type: "POST",
        url: $mainForm.attr("action"),
        data: formData,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        positionClass: "toast-top-left",
        beforeSend: function () {
            $submitBtn.html($savingLoader).addClass("disabled").attr("disabled", true);
        },
        success: function (response) {
            $submitBtn.html(originalHtml).removeClass("disabled").attr("disabled", false);

            if (response.redirect) {
                window.sessionStorage.hasPreviousMessage = true;
                window.sessionStorage.previousMessage = response.message ?? null;

                if (response.secondary_redirect_url) {
                    window.open(response.secondary_redirect_url, "_blank");
                }
                location.href = response.redirect;
            }

        },
        error: function (xhr) {
            $submitBtn.html(originalHtml).removeClass("disabled").attr("disabled", false);
            showInputErrors(xhr.responseJSON);
            Notify("error", xhr);
        }
    });
});

function ajaxSuccess(e, t) {
    e.redirect ? (e.message && ((window.sessionStorage.hasPreviousMessage = !0), (window.sessionStorage.previousMessage = e.message ?? null)), (location.href = e.redirect)) : e.message && Notify("success", e);
}

//PREVIEW IMAGE
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var inputId = $(input).attr('id');

            // Select the image element based on the input's ID
            var imageElement = $('img.product-img').filter(function () {
                return $(this).closest('label').attr('for') === inputId;
            });
            imageElement.attr('src', e.target.result);
            imageElement.hide().fadeIn(650);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$('.common-validation-modal').on('shown.bs.modal', function () {
    $(this).find('form.ajaxform_instant_reload').each(function () {
        $(this).validate();
    });
});

// Status button Change
$(".change-text").on("change", function () {
    var $dynamicText = $(this).closest('.form-control').find('.dynamic-text');

    if (this.checked) {
        $dynamicText.text("Active");
    } else {
        $dynamicText.text("Deactive");
    }
});

// Status button Change
$(".cnge-text").on("change", function () {
    var $test = $(this).closest('.form-control').find('.is-live-text');

    if (this.checked) {
        $test.text("Yes");
    } else {
        $test.text("No");
    }
});

/** STATUS CHANGE */
$('.status').on('change', function () {
    var checkbox = $(this);
    var status = checkbox.prop('checked') ? 1 : 0;
    var url = checkbox.data('url');
    var method = checkbox.data("method");

    $.ajax({
        url: url,
        type: method ?? 'POST',
        data: {
            status: status
        },
        success: function (response) {
            if (status === 1) {
                toastr.success((response.message ?? 'Module') + ' status published');
            } else {
                toastr.success((response.message ?? 'Module') + ' status unpublished');
            }
        },
        error: function (xhr, status, error) {
            console.log(error)
            toastr.error('Something Went Wrong');
        }
    });
});

$(document).ready(function () {
    /** SEARCH */
    $(".searchInput").on("input", function (e) {
        e.preventDefault();
        const searchText = $(this).val();
        const url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: searchText
            },
            success: function (res) {
                $(".searchResults").html(res.data);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    });

    // Handle the "x" icon click event
    $(".clearSearchInput").on("click", function () {
        $(".searchInput").val(""); // Clear the search input
        $(".clearSearchInput").addClass('d-none');
        $(this).closest('.searchForm').submit();
    });

    // Show/hide "delete" button based on input value
    $(".searchInput").on("input", function () {
        if ($(this).val().trim() !== "") {
            $(".clearSearchInput").removeClass('d-none');
        } else {
            $(".clearSearchInput").addClass('d-none');
        }
    });


});

/** CHECKBOX FOR DELETE ALL */
$(document).ready(function () {
    // Select all checkboxes when the checkbox in the header is clicked
    $(".selectAllCheckbox").on("click", function () {
        $(".checkbox-item").prop("checked", this.checked);
        if (this.checked) {
            $('.delete-selected').addClass('text-danger');
        } else {
            $('.delete-selected').removeClass('text-danger');
        }
    });

    // Perform the delete action for selected elements when the delete icon is clicked
    $(".delete-selected").on("click", function (e) {
        var checkedCheckboxes = $(".checkbox-item:checked");
        if (checkedCheckboxes.length === 0) {
            toastr.error('No items selected. Please select at least one item to delete.');
        } else {
            $('#multi-delete-modal').modal('show');
        }
    });


    $('.multi-delete-btn').on('click', function () {
        var ids = $(".checkbox-item:checked").map(function () {
            return $(this).val();
        }).get();

        let submitButton = $(this);
        let originalButtonText = submitButton.html();
        let del_url = $('.checkbox-item').data('url');

        $.ajax({
            type: "POST",
            url: del_url,
            data: {
                ids
            },
            dataType: "json",
            beforeSend: function () {
                submitButton.html($savingLoader).attr('disabled', true);
            },
            success: function (res) {
                submitButton.html(originalButtonText).attr('disabled', false);
                window.sessionStorage.hasPreviousMessage = true;
                window.sessionStorage.previousMessage = res.message ?? null;
                res.redirect && (location.href = res.redirect);
            },
            error: function (xhr) {
                submitButton.html(originalButtonText).attr('disabled', false);
                Notify('error', xhr);
            }
        });
    });
});

/** system setting start */
// Initial label text
var initialLabelText = $("#mail-driver-type-select option:selected").val();

$("#mail-driver-type-select").on("change", function () {
    var selectedOptionValue = $(this).val();
    $("#mail-driver-label").text(selectedOptionValue);
});

$("#mail-driver-label").text(initialLabelText);

/** system setting end */


/**  filter all from start */
$('.filter-form').on('input', function (e) {
    e.preventDefault();

    var table = $(this).attr('table');
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            $(table).html(res.data);
        }
    });
});

/**  filter all from  end */

$(document).ready(function () {

    $('#imageInput').on('change', function (event) {
        const file = this.files[0];

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {

                $('#imagePreview').attr('src', e.target.result);


                $('#fullImage').attr('src', e.target.result);
                $('#fullImagePreview').show();
            };


            reader.readAsDataURL(file);
        } else {

            $('#imagePreview').attr('src', "{{ asset('assets/images/icons/placeholder.svg') }}");
            $('#fullImagePreview').hide();
        }
    });


    $('.upload-v4').on('click', function () {
        $('#imageInput').click();
    });
});


// signup form Start
// sign up form
let $sign_up_form = $(".sign_up_form");
$sign_up_form.initFormValidation();

$(document).on("submit", ".sign_up_form", function (e) {
    e.preventDefault();

    let t = $(this).find(".submit-btn"),
        a = t.html();

    if ($sign_up_form.valid()) {
        $.ajax({
            type: "POST",
            url: this.action,
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                t.html($savingLoader) // Show loader
                    .addClass("disabled")
                    .attr("disabled", true);
            },
            success: function (response) {
                // Handle success response
                $("#registration-modal").modal("hide");
                $("#dynamicEmail").text(response.email);
                $("#verifymodal").modal("show");
                startCountdown(response.otp_expiration);
            },
            error: function (e) {
                // Handle error response
                showInputErrors(e.responseJSON);
                Notify("error", e);
            },
            complete: function () {
                t.html(a).removeClass("disabled").attr("disabled", false);
            },
        });
    }
});


// Verify OTP submission
let $verify_form = $(".verify_form");
$verify_form.initFormValidation();

$(document).on("submit", ".verify_form", function (e) {
    e.preventDefault();

    let t = $(this).find(".submit-btn"),
        a = t.html();

    const email = $("#dynamicEmail").text();

    // Get the OTP input values from the form
    const otpInputs = $(this).find(".otp-input");
    let otpValues = otpInputs
        .map(function () {
            return $(this).val();
        })
        .get()
        .join("");

    // Validate OTP and form before submitting
    if ($verify_form.valid()) {
        let formData = new FormData(this);
        formData.append("email", email);
        formData.append("otp", otpValues);

        $.ajax({
            type: "POST",
            url: this.action,
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                t.html($savingLoader).addClass("disabled").attr("disabled", true);
            },
            success: function (response) {
                t.html(a).removeClass("disabled").attr("disabled", false);

                // Hide OTP verification modal
                $("#verifymodal").modal("hide");

                // Check for successful OTP submission and show success modal
                if (response.redirect ?? false) {
                    window.sessionStorage.hasPreviousMessage = true;
                    window.sessionStorage.previousMessage = response.message || 'Operation successfully.';
                    location.href = response.redirect;
                } else {
                    // Show the success modal after OTP verification
                    $("#successmodal").modal("show");
                }
            },
            error: function (response) {
                t.html(a).removeClass("disabled").attr("disabled", false);
                toastr.error(
                    response.responseJSON.message || "An error occurred."
                );
            },
        });
    } else {
        toastr.error("Please enter all OTP digits.");
    }
});


// OTP input field--------------------->
const pinInputs = document.querySelectorAll(".pin-input");

pinInputs.forEach((inputField, index) => {
    inputField.addEventListener("input", () => {
        inputField.value = inputField.value.replace(/[^0-9]/g, "").slice(0, 1);

        if (inputField.value && index < pinInputs.length - 1) {
            pinInputs[index + 1].focus();
        }
    });

    inputField.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !inputField.value && index > 0) {
            pinInputs[index - 1].focus();
        }
    });

    inputField.addEventListener("paste", (e) => {
        e.preventDefault();
    });
});

function showInputErrors(e) {
    if (e.errors !== undefined) {
        $.each(e.errors, function (field, message) {
            $("#" + field + "-error").remove();

            let errorLabel = `
                <label id="${field}-error" class="error" for="${field}">${message}</label>
            `;

            $("#" + field)
                .parents()
                .hasClass("form-check")
                ? $("#" + field).parents().find(".form-check").append(errorLabel)
                : $("#" + field).addClass("error").after(errorLabel);
        });
    }
}

function ajaxSuccess(response, Notify) {
    if (response.redirect) {
        if (response.message) {
            window.sessionStorage.hasPreviousMessage = true;
            window.sessionStorage.previousMessage = response.message ?? null;
        }

        location.href = response.redirect;
    } else if (response.message) {
        Notify("success", response);
    }
}

// Invoice setting js start

$(".invoice-size-radio").on("change", function () {
    let $form = $(this).closest('.invoice_form');
    let submitUrl = $form.attr('action');

    $.ajax({
        type: "POST",
        url: submitUrl,
        data: new FormData($form[0]),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            Notify("info", null, "Updating invoice setting...");
        },
        success: function (response) {
            Notify("success", null, response ?? 'Invoice setting updated successfully.');
        },
        error: function (xhr) {
            let errorMsg = xhr.responseJSON?.message || 'Something went wrong!';
            Notify("error", null, errorMsg);
        }
    });
});

// Invoice setting js end

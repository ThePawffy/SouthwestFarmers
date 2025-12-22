"use strict";

$(".view-btn").each(function () {
    let container = $(this);
    let id = container.data("id");

    // User View Modal
    $("#user_view_" + id).on("click", function () {
        $("#user_view_business_category").text(
            $("#user_view_" + id).data("business_category")
        );
        $("#user_view_business_name").text(
            $("#user_view_" + id).data("business_name")
        );

        let imageSrc = $("#user_view_" + id).data("image");
        $("#user_view_image").attr("src", imageSrc);
        $("#user_view_name").text($("#user_view_" + id).data("name"));
        $("#user_view_role").text($("#user_view_" + id).data("role"));
        $("#user_view_email").text($("#user_view_" + id).data("email"));
        $("#user_view_phone").text($("#user_view_" + id).data("phone"));
        $("#user_view_address").text($("#user_view_" + id).data("address"));
        $("#user_view_country_id").text(
            $("#user_view_" + id).data("country_id")
        );
        $("#user_view_statfeatures-listus").text(
            $("#user_view_" + id).data("status") == 1 ? "Active" : "Deactive"
        );
    });

    // Plan View Modal
    $("#plan_view_" + id).on("click", function () {
        let features = $("#plan_view_" + id).data("features");
        let featuresList = $("#features-list");

        featuresList.empty();

        features.forEach((feature) => {
            let featureHtml = `
                <div class="row align-items-center mt-3 feature-entry">
                    <div class="col-md-1">
                        <p id="plan_view_features_yes">
                            ${
                                feature.value == 1
                                    ? '<i class="fas fa-check-circle"></i>'
                                    : '<i class="fas fa-times-circle"></i>'
                            }
                        </p>
                    </div>
                    <div class="col-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p id="plan_view_features_name">${feature.name}</p>
                    </div>
                </div>
            `;

            featuresList.append(featureHtml);
        });
    });

    // Category View
    $("#category_view_" + id).on("click", function () {
        $("#category_view_name").text($("#category_view_" + id).data("name"));
        $("#category_view_description").text(
            $("#category_view_" + id).data("description")
        );
        $("#category_view_status").text(
            $("#category_view_" + id).data("status") == 1
                ? "Active"
                : "Deactive"
        );
    });
    // Faqs view
    $("#faqs_view_" + id).on("click", function () {
        $("#faqs_view_question").text($("#faqs_view_" + id).data("question"));
        $("#faqs_view_answer").text($("#faqs_view_" + id).data("answer"));
        $("#faqs_view_status").text(
            $("#faqs_view_" + id).data("status") == 1 ? "Active" : "Deactive"
        );
    });
});

//Business view modal
$(".business-view").on("click", function () {
    $(".business_name").text($(this).data("name"));
    $("#image").attr("src", $(this).data("image"));
    $("#name").text($(this).data("name"));
    $("#address").text($(this).data("address"));
    $("#category").text($(this).data("category"));
    $("#phone").text($(this).data("phone"));
    $("#package").text($(this).data("package"));
    $("#last_enroll").text($(this).data("last_enroll"));
    $("#expired_date").text($(this).data("expired_date"));
    $("#created_date").text($(this).data("created_date"));
});

$("#plan_id").on("change", function () {
    $(".plan-price").val($(this).find(":selected").data("price"));
});

$(document).on("change", ".file-input-change", function () {
    let prevId = $(this).data("id");
    newPreviewImage(this, prevId);
});

// image preview
function newPreviewImage(input, prevId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#" + prevId).attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

//Upgrade plan
$(".business-upgrade-plan").on("click", function () {
    var url = $(this).data("url");

    $("#business_name").val($(this).data("name"));
    $("#business_id").val($(this).data("id"));
    $(".upgradePlan").attr("action", url);
});

$(".modal-reject").on("click", function () {
    var url = $(this).data("url");
    $(".modalRejectForm").attr("action", url);
});

$(".modal-approve").on("click", function () {
    var url = $(this).data("url");
    $(".modalApproveForm").attr("action", url);
});

//edit banner
$(".edit-btn").each(function () {
    let container = $(this);
    let service = container.data("id");
    let id = service;
    $("#edit-banner-" + service).on("click", function () {
        $("#checkbox").prop(
            "checked",
            $("#edit-banner-" + service).data("status") == 1
        );
        $(".dynamic-text").text(
            $("#edit-banner-" + service).data("status") == 1
                ? "Active"
                : "Deactive"
        );

        let edit_action_route = $(this).data("url");
        $("#editForm").attr("action", edit_action_route + "/" + id);
    });
});

$(".edit-banner-btn").on("click", function () {
    $(".edit-imageUrl-form").attr("action", $(this).data("url"));
    $("#edit-imageUrl").attr("src", $(this).data("image"));
    $("#edit-name").val($(this).data("name"));
});

$(".edit-business-category-btn").on("click", function () {
    $("#editBusenessCategory").attr("action", $(this).data("url"));
    $("#edit-name").val($(this).data("name"));
});

$(function () {
    $("body").on("click", ".remove-one", function () {
        $(this).closest(".remove-list").remove();
    });
});
/** Subscriptions Plan end */

$(document).on("click", ".add-new-item", function () {
    let html = `
    <div class="row row-items">
        <div class="col-sm-5">
            <label for="">Label</label>
            <input type="text" name="manual_data[label][]" value="" class="form-control" placeholder="Enter label name">
        </div>
        <div class="col-sm-5">
            <label for="">Select Required/Optionl</label>
            <select class="form-control" required name="manual_data[is_required][]">
                <option value="1">Required</option>
                <option value="0">Optional</option>
            </select>
        </div>
        <div class="col-sm-2 align-self-center mt-3">
            <button type="button" class="btn text-danger trash remove-btn-features"><i class="fas fa-trash"></i></button>
        </div>
    </div>
    `;
    $(".manual-rows").append(html);
});

$(document).on("click", ".remove-btn-features", function () {
    var $row = $(this).closest(".row-items");
    $row.remove();
});

// Staff view Start
$(".staff-view-btn").on("click", function () {
    var staffName = $(this).data("staff-view-name");
    var staffPhone = $(this).data("staff-view-phone-number");
    var staffemail = $(this).data("staff-view-email-number");
    var staffRole = $(this).data("staff-view-role");

    $("#staff_view_name").text(staffName);
    $("#staff_view_phone_number").text(staffPhone);
    $("#staff_view_email_number").text(staffemail);
    $("#staff_view_role").text(staffRole);
});
// Staff view End

var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// subscription-plan-edit-custom-input size
const inputs = document.querySelectorAll(
    ".subscription-plan-edit-custom-input"
);

function resizeInput() {
    const tempSpan = document.createElement("span");
    tempSpan.style.visibility = "hidden";
    tempSpan.style.position = "absolute";
    tempSpan.style.whiteSpace = "pre";
    tempSpan.style.font = window.getComputedStyle(this).font;
    tempSpan.textContent = this.value || this.placeholder;

    document.body.appendChild(tempSpan);

    this.style.width = tempSpan.offsetWidth + 20 + "px"; // 20 mean by, left + right = 20px. please check css

    document.body.removeChild(tempSpan);
}

inputs.forEach(function (input) {
    input.addEventListener("input", resizeInput);
    resizeInput.call(input);
});

//Dynamic Tags Setting Start
$(document).on("click", ".add-new-tag", function () {
    let html = `
        <div class="col-sm-5">
            <label for="">Tags</label>
            <input type="text" name="tags[]" value="" class="form-control" placeholder="Enter tags name">
        </div>
        <div class="col-sm-1 align-self-center mt-3">
            <button type="button" class="btn text-danger trash remove-tag-btn"><i class="fas fa-trash"></i></button>
        </div>
    `;
    $(".row-items").append(html);
});

$(document).on("click", ".remove-tag-btn", function () {
    var $row = $(this).closest(".row-items");
    $row.remove();
});

//Dynamic Tags Setting End

// image preview Start
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(input)
                .closest(".row")
                .find(".multi-image-preview")
                .attr("src", e.target.result);
            $(input).closest(".row").find(".multi-image-preview").hide();
            $(input).closest(".row").find(".multi-image-preview").fadeIn(650);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
// image preview End

// Password show hide start
$(document).ready(function () {
    $(".eye-btn").on("click", function () {
        var passwordField = $('input[name="password"]');
        var icon = $(this);

        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
});

// Password show hide End

//Subscriber view modal
$(".subscriber-view").on("click", function () {
    $(".business_name").text($(this).data("name"));
    $("#image").attr("src", $(this).data("image"));
    $("#category").text($(this).data("category"));
    $("#package").text($(this).data("package"));
    $("#gateway").text($(this).data("gateway"));
    $("#enroll_date").text($(this).data("enroll"));
    $("#expired_date").text($(this).data("expired"));

    var gateway_img = $(this).data("manul-attachment");

    if (gateway_img) {
        var img = new Image();
        img.onload = function () {
            $("#manual_img").removeClass("d-none");
            $("#manul_attachment").attr("src", gateway_img);
        };
        img.onerror = function () {
            $("#manual_img").addClass("d-none");
        };
        img.src = gateway_img;
    } else {
        $("#manual_img").addClass("d-none");
    }
});

//Subscriber view modal end

//plans feature
$("#multiple_feature").click(function (e) {
    e.preventDefault();

    let value = $(".add-feature").val();
    let featureCount = $(".feature-list").children().length;

    $(".feature-list").append(`
        <div class="feature-item extra-feature-input">
            <div class="form-control m-0 d-flex justify-content-between align-items-center">
            <input type="text" name="features[features_${featureCount}][]" placeholder="Enter Extra feature" class="add-feature-${featureCount} add-extra-feature">
            <div class='d-flex align-items-center gap-4'>
            <label class="switch m-0">
                <input type="checkbox" checked value="1" name="features[features_${featureCount}][]">
                <span class="slider round"></span>
            </label>
        <svg class="delete-feature" width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.5 5.58342H17.5M13.3796 5.58342L12.8107 4.40986C12.4328 3.6303 12.2438 3.24051 11.9179 2.99742C11.8457 2.9435 11.7691 2.89553 11.689 2.854C11.3281 2.66675 10.8949 2.66675 10.0286 2.66675C9.1405 2.66675 8.6965 2.66675 8.32957 2.86185C8.24826 2.90509 8.17066 2.955 8.09758 3.01106C7.76787 3.264 7.5837 3.66804 7.21535 4.47613L6.71061 5.58342" stroke="#F54336" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M16.25 5.5835L15.7336 13.9377C15.6016 16.0722 15.5357 17.1394 15.0007 17.9067C14.7361 18.2861 14.3956 18.6062 14.0006 18.8468C13.2017 19.3335 12.1325 19.3335 9.99392 19.3335C7.8526 19.3335 6.78192 19.3335 5.98254 18.8459C5.58733 18.6049 5.24667 18.2842 4.98223 17.9042C4.4474 17.1357 4.38287 16.0669 4.25384 13.9295L3.75 5.5835" stroke="#F54336" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M7.5 10.7717H12.5" stroke="#F54336" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M8.75 14.1467H11.25" stroke="#F54336" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
            </div>
            </div>
        </div>
    `);
});

$(document).on("click", ".delete-feature", function () {
    $(this).closest(".feature-item").remove();
});

document.addEventListener("DOMContentLoaded", function () {
    const fileInputs = document.querySelectorAll(
        'input[type="file"][data-preview]'
    );

    fileInputs.forEach(function (input) {
        input.addEventListener("change", function () {
            const previewId = this.getAttribute("data-preview");
            const previewImg = document.getElementById(previewId);

            if (this.files && this.files[0] && previewImg) {
                previewImg.src = window.URL.createObjectURL(this.files[0]);
            }
        });
    });
});

// Faq edit
$(".faq-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var question = $(this).data("question");
    var answer = $(this).data("answer");

    $("#question").val(question);
    $("#answer").val(answer);

    $(".faqUpdateForm").attr("action", url);
});

// Tutorial edit
$(".tutorial-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var title = $(this).data("title");
    var turorial_url = $(this).data("tutorial-url");
    var thumbnail = $(this).data("thumbnail");

    $("#title").val(title);
    $("#url").val(turorial_url);
    $("#thumbnail").attr('src', thumbnail);

    $(".tutorialUpdateForm").attr("action", url);
});

// Preview img
$("input[type='file']").on("change", function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $(".preview").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    }
});

  document.addEventListener("DOMContentLoaded", function () {
    const closeBtn = document.querySelector("#demoAlert .btn-close");
    const alertBox = document.getElementById("demoAlert");

    closeBtn.addEventListener("click", function () {
      alertBox.style.display = "none";
    });
  });

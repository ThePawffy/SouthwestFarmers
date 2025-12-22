"use strict";

function formatNumber(value) {
    return value % 1 === 0 ? value.toFixed(0) : value.toFixed(2);
}

// currency format
function currencyFormat(amount, type = "icon", decimals = 2) {
    let symbol = $("#currency_symbol").val();
    let position = $("#currency_position").val();
    let code = $("#currency_code").val();

    let formattedAmount = formatNumber(amount, decimals); // Abbreviate number

    // Apply currency format based on the position and type
    if (type === "icon" || type === "symbol") {
        return position === "right" ? formattedAmount + symbol : symbol + formattedAmount;
    } else {
        return position === "right" ? formattedAmount + " " + code : code + " " + formattedAmount;
    }
}

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

$(".business-upgrade-plan").on("click", function () {
    let url = $(this).data("url");
    let businessName = $(this).data("name");
    let businessId = $(this).data("id");

    // Set form values
    $("#business_name").val(businessName);
    $("#business_id").val(businessId);
    $(".upgradePlan").attr("action", url);
});

$("#plan_id").on("change", function () {
    $(".plan-price").val($(this).find(":selected").data("price"));
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
    let status = $(this).data("status");
    $(".edit-status").prop("checked", status);
    $(".edit-imageUrl-form").attr("action", $(this).data("url"));
    $("#edit-imageUrl").attr("src", $(this).data("image"));

    if (status == 1) {
        $(".dynamic-text").text("Active");
    } else {
        $(".dynamic-text").text("Deactive");
    }
});

$(function () {
    $("body").on("click", ".remove-one", function () {
        $(this).closest(".remove-list").remove();
    });
});
/** Subscriptions Plan end */

//Dynamic Tags Setting Start

$(document)
    .off("click", ".add-new-tag")
    .on("click", ".add-new-tag", function () {
        let html = `
    <div class="col-md-6">
        <div class="row row-items">
            <div class="col-sm-10">
                <label for="">Tags</label>
                <input type="text" name="tags[]" class="form-control" required
                    placeholder="Enter tags name">
            </div>
            <div class="col-sm-2 align-self-center mt-3">
                <button type="button" class="btn text-danger trash remove-btn-features"
                    onclick="removeDynamicField(this)"><i
                        class="fas fa-trash"></i></button>
            </div>
        </div>
    </div>
    `;
        $(".manual-rows .single-tags").append(html);
    });
//Dynamic tag ends

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

// ------------BUSINESS PANEL START ---------------------------------------------------------

$(".category-edit-btn").on("click", function () {
    var modal = $("#category-edit-modal");

    $("#category_name").val($(this).data("category-name"));
    $("#category_icon").attr("src", $(this).data("category-icon"));

    // Handle checkboxes for variations
    $("#capacityCheck").prop(
        "checked",
        $(this).data("category-variationcapacity") === 1
    );
    $("#colorCheck").prop(
        "checked",
        $(this).data("category-variationcolor") === 1
    );
    $("#sizeCheck").prop(
        "checked",
        $(this).data("category-variationsize") === 1
    );
    $("#typeCheck").prop(
        "checked",
        $(this).data("category-variationtype") === 1
    );
    $("#weightCheck").prop(
        "checked",
        $(this).data("category-variationweight") === 1
    );

    modal.find("form").attr("action", $(this).data("url"));
});

$(".units-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var unitName = $(this).data("units-name");
    var unitStatus = $(this).data("units-status");

    $("#unit_view_name").val(unitName);
    $("#unit_status").val(unitStatus);

    if (unitStatus == 1) {
        $("#unit_status").prop("checked", true);
        $(".dynamic-text").text("Active");
    } else {
        $("#unit_status").prop("checked", false);
        $(".dynamic-text").text("Deactive");
    }
    $(".unitUpdateForm").attr("action", url);
});

$(document).on("click", ".model-edit-btn", function () {
    var url = $(this).data("url");
    var modelName = $(this).data("model-name");
    var modelStatus = $(this).data("model-status");

    $("#model_name").val(modelName);
    $("#model_status").val(modelStatus);

    if (modelStatus == 1) {
        $("#model_status").prop("checked", true);
        $(".dynamic-text").text("Active");
    } else {
        $("#model_status").prop("checked", false);
        $(".dynamic-text").text("Deactive");
    }

    $(".modelUpdateForm").attr("action", url);
});



$(".brand-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var brand_name = $(this).data("brands-name");
    var brand_icon = $(this).data("brands-icon");
    var brand_description = $(this).data("brands-description");

    $("#brand_view_name").val(brand_name);
    $("#edit_icon").attr("src", brand_icon);
    $("#brand_view_description").val(brand_description);

    $(".brandUpdateForm").attr("action", url);
});


$(".parties-view-btn").on("click", function () {
    $("#parties_name").text($(this).data("name"));
    $("#parties_phone").text($(this).data("phone"));
    $("#parties_email").text($(this).data("email"));
    $("#parties_type").text($(this).data("type"));
    $("#parties_address").text($(this).data("address"));
    $("#parties_due").text($(this).data("due"));
});

$(".income-categories-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var name = $(this).data("income-categories-name");
    var description = $(this).data("income-categories-description");

    $("#income_categories_view_name").val(name);
    $("#income_categories_view_description").val(description);

    $(".incomeCategoryUpdateForm").attr("action", url);
});

$(".expense-categories-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var expense_name = $(this).data("expense-categories-name");
    var expense_description = $(this).data("expense-categories-description");

    $("#expense_categories_view_name").val(expense_name);
    $("#expense_categories_view_description").val(expense_description);

    $(".expenseCategoryUpdateForm").attr("action", url);
});

$(".incomes-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var income_category_id = $(this).data("income-category-id");
    var incomeAmount = $(this).data("income-amount");
    var incomeFor = $(this).data("income-for");
    var incomePaymentType = $(this).data("income-payment-type");
    var incomePaymentTypeId = $(this).data("income-payment-type-id");
    var incomeReferenceNo = $(this).data("income-reference-no");
    var incomedate = $(this).data("income-date-update");
    var incomenote = $(this).data("income-note");
    $("#income_categoryId").val(income_category_id);
    $("#inc_price").val(incomeAmount);
    $("#inc_for").val(incomeFor);
    if (
        incomePaymentTypeId !== null &&
        incomePaymentTypeId !== undefined &&
        incomePaymentTypeId !== ""
    ) {
        $("#inc_paymentType").val(incomePaymentTypeId);
    } else {
        $("#inc_paymentType option").each(function () {
            if ($(this).text().trim() === incomePaymentType) {
                $(this).prop("selected", true);
            }
        });
    }
    $("#incomeReferenceNo").val(incomeReferenceNo);
    $("#inc_date_update").val(incomedate);
    $("#inc_note").val(incomenote);

    $(".incomeUpdateForm").attr("action", url);
});

$(".expense-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var expenseCategoryId = $(this).data("expense-category-id");
    var expenseAmount = $(this).data("expense-amount");
    var expensePaymentType = $(this).data("expense-payment-type");
    var expensePaymentTypeId = $(this).data("expense-payment-type-id");
    var expenseReferenceNo = $(this).data("expense-reference-no");
    var expenseFor = $(this).data("expense-for");
    var expenseDate = $(this).data("expense-date");
    var expenseNote = $(this).data("expense-note");

    // Set the values in the modal's fields
    $("#expenseCategoryId").val(expenseCategoryId);
    $("#expense_amount").val(expenseAmount);
    if (
        expensePaymentTypeId !== null &&
        expensePaymentTypeId !== undefined &&
        expensePaymentTypeId !== ""
    ) {
        $("#expensePaymentType").val(expensePaymentTypeId);
    } else {
        $("#expensePaymentType option").each(function () {
            if ($(this).text().trim() === expensePaymentType) {
                $(this).prop("selected", true);
            }
        });
    }
    $("#refeNo").val(expenseReferenceNo);
    $("#expe_for").val(expenseFor);
    $("#edit_date_expe").val(expenseDate);
    $("#expenote").val(expenseNote);

    // Update the form action attribute
    $(".expenseUpdateForm").attr("action", url);
});

function showTab(tabId) {
    // Activate selected tab
    document
        .querySelectorAll(".tab-item")
        .forEach((tab) => tab.classList.remove("active"));
    document
        .querySelectorAll(".tab-content")
        .forEach((content) => content.classList.remove("active"));

    document.getElementById(tabId).classList.add("active");
    document
        .querySelector(`[onclick="showTab('${tabId}')"]`)
        .classList.add("active");

    // Get the base URL from the hidden input fields
    const csvBaseUrl = document.getElementById("csvBaseUrl").value;
    const excelBaseUrl = document.getElementById("excelBaseUrl").value;

    // Set correct export type
    let type = tabId == "sales" ? "sales" : "purchases";

    // Update export URLs dynamically
    const csv = document.getElementById("csvExportLink");
    const excel = document.getElementById("excelExportLink");

    if (csv) {
        csv.href = `${csvBaseUrl}?type=${type}`;
    }
    if (excel) {
        excel.href = `${excelBaseUrl}?type=${type}`;
    }
}

// Multidelete Start
function updateSelectedCount() {
    var selectedCount = $(".delete-checkbox-item:checked").length;
    $(".selected-count").text(selectedCount);

    if (selectedCount > 0) {
        $(".delete-show").removeClass("d-none");
    } else {
        $(".delete-show").addClass("d-none");
    }
}

$(".select-all-delete").on("click", function () {
    $(".delete-checkbox-item").prop("checked", this.checked);
    updateSelectedCount();
});

$(document).on("change", ".delete-checkbox-item", function () {
    updateSelectedCount();
});

$(".trigger-modal").on("click", function () {
    var dynamicUrl = $(this).data("url");

    $("#dynamic-delete-form").attr("action", dynamicUrl);

    var ids = $(".delete-checkbox-item:checked")
        .map(function () {
            return $(this).val();
        })
        .get();

    if (ids.length === 0) {
        alert("Please select at least one item.");
        return;
    }

    var form = $("#dynamic-delete-form");
    form.find("input[name='ids[]']").remove();
    ids.forEach(function (id) {
        form.append('<input type="hidden" name="ids[]" value="' + id + '">');
    });
});

$(".create-all-delete").on("click", function (event) {
    event.preventDefault();

    var form = $("#dynamic-delete-form");
    form.submit();
});

// Multidelete End

// Collects Due Start
$("#invoiceSelect").on("change", function () {
    const selectedOption = $(this).find("option:selected");
    const dueAmount = selectedOption.data("due-amount");
    const openingDue = selectedOption.data("opening-due");

    if (!selectedOption.val()) {
        $("#totalAmount").val(openingDue.toFixed(2));
        $("#dueAmount").val(openingDue.toFixed(2));
    } else {
        $("#totalAmount").val(dueAmount.toFixed(2));
        $("#dueAmount").val(dueAmount.toFixed(2));
    }

    calculateDueChange();
});

$("#paidAmount").on("input", function () {
    calculateDueChange();
});
function calculateDueChange() {
    const payingAmount = parseFloat($("#paidAmount").val()) || 0;
    const totalAmount = parseFloat($("#totalAmount").val()) || 0;

    if (payingAmount > totalAmount) {
        toastr.error("cannot pay more than due.");
    }

    const updatedDueAmount = totalAmount - payingAmount;
    $("#dueAmount").val(
        (updatedDueAmount >= 0 ? updatedDueAmount : 0).toFixed(2)
    );
}
// Collects Due End

//Subscriber view modal
$(".subscriber-view").on("click", function () {
    $(".business_name").text($(this).data("name"));
    $("#image").attr("src", $(this).data("image"));
    $("#category").text($(this).data("category"));
    $("#package").text($(this).data("package"));
    $("#gateway").text($(this).data("gateway"));
    $("#enroll_date").text($(this).data("enroll"));
    $("#expired_date").text($(this).data("expired"));
    $("#manul_attachment").attr("src", $(this).data("manul-attachment"));
});

/** barcode: start **/
$("#product-search").on("keyup click", function () {
    const query = $(this).val().toLowerCase();
    const fetchRoute = $("#fetch-products-route").val();
    // Fetch matching products
    $.ajax({
        url: fetchRoute,
        type: "GET",
        data: { search: query },
        dataType: "json",
        success: function (data) {
            let productList = "";
            if (data.length > 0) {
                data.forEach((product) => {
                    productList += `
                            <li
                                class="list-group-item product-item"
                                data-id="${product.id}"
                                data-name="${product.productName}"
                                data-code="${product.productCode}"
                                data-stock="${product.productStock}">
                                ${product.productName} (${product.productCode})
                            </li>`;
                });
            } else {
                productList =
                    '<li class="list-group-item text-danger">No products found.</li>';
            }
            $("#search-results").html(productList).show();
        },
        error: function () {
            console.log("Unable to fetch products. Please try again later.");
        },
    });
});

// Hide search results when clicking outside
$(document).on("click", function (e) {
    if (!$(e.target).closest("#product-search, #search-results").length) {
        $("#search-results").hide();
    }
});

// When a product is selected from the list
$(document).on("click", ".product-item", function () {
    const productId = $(this).data("id");
    const productName = $(this).data("name");
    const productCode = $(this).data("code");
    const productStock = $(this).data("stock");

    // Add the product to the table if not already added
    if (!$('#product-list tr[data-id="' + productId + '"]').length) {
        const newRow = `
            <tr data-id="${productId}">
                <td class="text-start">${productName}</td>
                <td>${productCode}</td>
                <td>${productStock}</td>
                <td class="large-td">
                    <div class="d-flex align-items-center justify-content-center">
                        <button class="incre-decre sub-btn"><i class="fas fa-minus icon"></i></button>
                        <input type="number" name="qty[]" value="1" class="custom-number-input pint-qty" placeholder="0">
                        <button class="incre-decre add-btn"><i class="fas fa-plus icon"></i></button>
                    </div>
                </td>
                <td class="large-td">
                    <input type="date" name="preview_date[]"  class="form-control input-date">
                </td>
                <td>
                    <button class="x-btn remove-btn text-danger">
                        <i class="far fa-times "></i>
                    </button>
                </td>
              <input type="hidden" name="product_ids[]" value="${productId}">
            </tr>`;
        $("#product-list").append(newRow);
    }

    $("#search-results").hide();
    $("#product-search").val("");
});

$(document).on("click", ".remove-btn", function () {
    $(this).closest("tr").remove();
});

// Increase quantity
$(document).on("click", ".add-btn", function (e) {
    e.preventDefault();
    const qtyInput = $(this).siblings(".pint-qty");
    let currentQty = parseInt(qtyInput.val(), 10) || 0;
    qtyInput.val(currentQty + 1);
});

// Decrease quantity
$(document).on("click", ".sub-btn", function (e) {
    e.preventDefault();
    const qtyInput = $(this).siblings(".pint-qty");
    let currentQty = parseInt(qtyInput.val(), 10) || 1;
    if (currentQty > 1) {
        qtyInput.val(currentQty - 1);
    }
});

let $savingLoader1 =
        '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
    $barcodeForm = $(".barcodeForm");

$barcodeForm.initFormValidation(),
    $(document).on("submit", ".barcodeForm", function (e) {
        e.preventDefault();
        let t = $(this).find("#barcode-preview-btn"),
            a = t.html();

        if ($barcodeForm.valid()) {
            $.ajax({
                type: "POST",
                url: this.action,
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    t.html($savingLoader1).attr("disabled", true);
                },
                success: function (e) {
                    t.html(a).removeClass("disabled").attr("disabled", false);

                    if (e.secondary_redirect_url) {
                        // Open the print page and trigger window.print()
                        let printWindow = window.open(
                            e.secondary_redirect_url,
                            "_blank"
                        );

                        if (printWindow) {
                            printWindow.onload = function () {
                                printWindow.print();
                            };
                        }
                    }

                    if (e.redirect) {
                        location.href = e.redirect;
                    }
                },
                error: function (e) {
                    t.html(a).attr("disabled", false);
                    Notify("error", e);
                },
            });
        }
    });

/** Barcode: end **/

//Vat start
$(".vat-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var name = $(this).data("vat-name");
    var rate = $(this).data("vat-rate");
    var newrate = $(this).data("new-vat-rate");
    var status = $(this).data("vat-status");

    $("#vat_name").val(name);
    $("#vat_rate").val(rate);
    $("#new_vat_rate").val(newrate);
    $("#vat_status").val(status);
    $(".updateVatForm").attr("action", url);
});
//Vat End

/** Report Filter: Start **/

// Handle Custom Date Selection
$(".custom-days").on("change", function () {
    let selected = $(this).val();
    let dateFilters = $(".date-filters");

    // Show or hide the date filters based on selection
    if (selected === "custom_date") {
        dateFilters.removeClass("d-none");
    } else {
        dateFilters.addClass("d-none");
    }

    // Trigger the form submission to apply the filters
    $(".report-filter-form").trigger("input");
});
// Report Filter Form Submission
$(".report-filter-form").on("input change", function (e) {
    e.preventDefault();
    let form = $(this);
    let table = form.attr("table");

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            $(table).html(res.data);
            if (res.total_sale !== undefined) {
                $("#total_sale").text(res.total_sale);
            }
            if (res.total_sale_return !== undefined) {
                $("#total_sale_return").text(res.total_sale_return);
            }
            if (res.total_purchase !== undefined) {
                $("#total_purchase").text(res.total_purchase);
            }
            if (res.total_purchase_return !== undefined) {
                $("#total_purchase_return").text(res.total_purchase_return);
            }
            if (res.total_income !== undefined) {
                $("#total_income").text(res.total_income);
            }
            if (res.total_expense !== undefined) {
                $("#total_expense").text(res.total_expense);
            }
            if (res.total_loss !== undefined) {
                $("#total_loss").text(res.total_loss);
            }
            if (res.total_profit !== undefined) {
                $("#total_profit").text(res.total_profit);
            }
            if (res.total_sale_count !== undefined) {
                $("#total_sale_count").text(res.total_sale_count);
            }
            if (res.total_due !== undefined) {
                $("#total_due").text(res.total_due);
            }
            if (res.total_paid !== undefined) {
                $("#total_paid").text(res.total_paid);
            }
            //

            if (res.opening_stock_by_purchase !== undefined) {
                $("#opening_stock_by_purchase").text(
                    res.opening_stock_by_purchase
                );
            }

            if (res.closing_stock_by_purchase !== undefined) {
                $("#closing_stock_by_purchase").text(
                    res.closing_stock_by_purchase
                );
            }

            if (res.total_purchase_price !== undefined) {
                $("#total_purchase_price").text(res.total_purchase_price);
            }

            if (res.total_purchase_shipping_charge !== undefined) {
                $("#total_purchase_shipping_charge").text(
                    res.total_purchase_shipping_charge
                );
            }

            if (res.total_purchase_discount !== undefined) {
                $("#total_purchase_discount").text(res.total_purchase_discount);
            }

            if (res.all_purchase_return !== undefined) {
                $("#all_purchase_return").text(res.all_purchase_return);
            }

            if (res.all_sale_return !== undefined) {
                $("#all_sale_return").text(res.all_sale_return);
            }

            if (res.opening_stock_by_sale !== undefined) {
                $("#opening_stock_by_sale").text(res.opening_stock_by_sale);
            }

            if (res.closing_stock_by_sale !== undefined) {
                $("#closing_stock_by_sale").text(res.closing_stock_by_sale);
            }

            if (res.total_sale_price !== undefined) {
                $("#total_sale_price").text(res.total_sale_price);
            }

            if (res.total_sale_shipping_charge !== undefined) {
                $("#total_sale_shipping_charge").text(
                    res.total_sale_shipping_charge
                );
            }

            if (res.total_sale_discount !== undefined) {
                $("#total_sale_discount").text(res.total_sale_discount);
            }

            if (res.total_sale_rounding_off !== undefined) {
                $("#total_sale_rounding_off").text(res.total_sale_rounding_off);
            }
        },
    });
});
/** Report Filter: End **/

// When the user clicks on the show/hide icon
$(".hide-show-icon").click(function () {
    let input = $(this).siblings("input");
    let showIcon = $(this).find(".showIcon");
    let hideIcon = $(this).find(".hideIcon");

    input.attr("type", input.attr("type") === "password" ? "text" : "password");

    showIcon.toggleClass("d-none");
    hideIcon.toggleClass("d-none");
});

// Payment Type Edit Start
$(".payment-types-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var PaymentTypeName = $(this).data("payment-types-name");
    var PaymentTypeStatus = $(this).data("payment-types-status");

    $("#PaymentTypeName").val(PaymentTypeName);
    $("#PaymentTypeStatus").val(PaymentTypeStatus);

    $(".paymentTypeUpdateForm").attr("action", url);
});
// Payment Type Edit End
const tabLinks = document.querySelectorAll(".data-tab a");

tabLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
        e.preventDefault();

        tabLinks.forEach((item) => item.classList.remove("active"));

        this.classList.add("active");
    });
});

$(document).ready(function () {
    $("form").on("reset", function () {
        var defaultImage = $("#default-image").val();

        $(this)
            .find(".upload-img-container img")
            .each(function () {
                $(this).attr("src", defaultImage);
            });

        $(this).find("input[type='file']").val("");
    });
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

$(document).ready(function () {
    const $vatSelect = $('#sub_vat');
    if ($vatSelect.length && typeof Choices !== 'undefined') {
        new Choices($vatSelect[0], {
            removeItemButton: true,
            placeholder: true,
            placeholderValue: "Select VAT options",
            searchEnabled: true,
        });
    }
});

// Choices select js start

$(document).ready(function () {
    const choicesMap = new Map();

    $(".choices-select").each(function () {
        const select = this;
        const choicesInstance = new Choices(select, {
            searchEnabled: true,
            itemSelectText: "",
            shouldSort: false,
        });
        choicesMap.set(select.id, choicesInstance);
    });

    $(document).on("keydown", ".choices__input--cloned", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const activeInput = $(this);
            const searchTerm = activeInput.val().trim();

            if (!searchTerm) return;
            const choicesContainer = activeInput.closest('.choices');

            const selectId = choicesContainer.attr('class').split(' ').find(cls => cls.startsWith('choices-'))?.replace('choices-', '');

            let selectElement = selectId ? $('#' + selectId) : choicesContainer.siblings('select.choices-select');

            if (!selectElement.length) {
                selectElement = $('.choices-select');
            }

            if (!selectElement.length) return;

            const finalSelectId = selectElement.attr('id');

            const isCustomer = finalSelectId === 'party_id';
            const isSupplier = finalSelectId === 'supplier_id';

            if (!isCustomer && !isSupplier) return;

            let matchFound = false;

            selectElement.find("option").each(function () {
                const optionText = $(this).text().trim().toLowerCase();
                if (optionText.includes(searchTerm.toLowerCase())) {
                    matchFound = true;
                    return false;
                }
            });

            if (!matchFound) {
                const modalId = isCustomer ? '#customer-create-modal' : '#supplier-create-modal';
                const modalNameInput = $(modalId).find('input[name="name"]');
                const modalPhoneInput = $(modalId).find('input[name="phone"]');

                if (!modalNameInput.length) return;

                // Check if search term is a phone number
                const phoneRegex = /^(\+?[0-9]{1,15}|[0-9]{3,})$/;
                const isPhoneNumber = phoneRegex.test(searchTerm);

                selectElement.val('').trigger("change");

                if (isPhoneNumber && modalPhoneInput.length) {
                    modalPhoneInput.val(searchTerm);
                } else {
                    modalNameInput.val(searchTerm);
                }

                new bootstrap.Modal($(modalId)[0]).show();
                activeInput.val('');
            }
        }
    });
});
// Choices select js end

// date type js for product settings start
$(".date-type-selector").on("change", function () {
    const target = $(this).data("target");
    const selectedType = $(this).val();

    if (selectedType === "dmy") {
        $("#" + target + "_dmy").show();
        $("#" + target + "_my").hide();
    } else if (selectedType === "my") {
        $("#" + target + "_my").show();
        $("#" + target + "_dmy").hide();
    } else {
        $("#" + target + "_my, #" + target + "_dmy").hide();
    }
});
// date type js for product settings end

// Loss/Profit view
$(document).on("click", ".loss-profit-view", function () {
    let lossProfitId = $(this).data("id");
    let url = $("#loss-profit-id").val();

    $.ajax({
        url: url.replace(":id", lossProfitId),
        type: "GET",
        success: function (data) {
            let tbody = $("#loss-profit-view tbody");
            console.log($("#loss-profit-view tbody").length);

            tbody.empty();

            $("#loss-profit-view .modal-title").text(
                `Invoice: ${data.invoiceNumber} - ${data.party?.name || "N/A"}`
            );

            let sl = 1;
            let totalQty = 0;
            let totalPurchase = 0;
            let totalSale = 0;
            let totalProfit = 0;
            let totalLoss = 0;

            data.details.forEach((detail) => {
                let quantity = detail.quantities || 0;
                let purchasePrice = detail.productPurchasePrice || 0;
                let salePrice = detail.price || 0;
                let profit = detail.lossProfit > 0 ? detail.lossProfit : 0;
                let loss =
                    detail.lossProfit < 0 ? Math.abs(detail.lossProfit) : 0;
                let batchNo = detail.batch_no || "-";

                totalQty += quantity;
                totalPurchase += purchasePrice;
                totalSale += salePrice;
                totalProfit += profit;
                totalLoss += loss;

                let row = `
                    <tr>
                        <td>${sl++}</td>
                        <td class="text-start">${
                    detail.product?.productName || "-"
                }</td>
                        <td class="text-start">${batchNo}</td>
                        <td class="text-start">${quantity}</td>
                        <td class="text-start">${currencyFormat(
                    purchasePrice
                )}</td>
                        <td class="text-start">${currencyFormat(salePrice)}</td>
                        <td class="text-start text-success">${currencyFormat(
                    profit
                )}</td>
                        <td class="text-start text-danger">${currencyFormat(
                    loss
                )}</td>
                    </tr>
                `;
                tbody.append(row);
            });

            let income = totalProfit - totalLoss;

            // Append summary rows
            let summary = `
                <tr class="fw-bold bg-light">
                    <td colspan="3" class="text-end">Total:</td>
                    <td class="text-start">${totalQty}</td>
                    <td class="text-start">${currencyFormat(totalPurchase)}</td>
                    <td class="text-start">${currencyFormat(totalSale)}</td>
                    <td class="text-start text-success">${currencyFormat(
                totalProfit
            )}</td>
                    <td class="text-start text-danger">${currencyFormat(
                totalLoss
            )}</td>
                </tr>
                <tr>
                    <td colspan="8" class="border-0 pt-3"><strong class="text-success">Total Profit: ${currencyFormat(
                totalProfit
            )}</strong></td>
                </tr>
                <tr>
                    <td colspan="8" class="border-0"><strong class="text-danger">Total Loss: ${currencyFormat(
                totalLoss
            )}</strong></td>
               </tr>
                <tr>
                    <td colspan="8" class="border-0"><strong class="text-primary">Net Profit: ${currencyFormat(
                income
            )}</strong></td>
                </tr>
            `;
            tbody.append(summary);
        },
        error: function (xhr) {
            console.error(
                "Failed to load sale data:",
                xhr.status,
                xhr.responseText
            );
        },
    });
});

//Demo Alert show
$(document).ready(function() {
    $("#demoAlert .btn-close").on("click", function() {
        $("#demoAlert").hide();
    });
  });

/** multiple payment type add dynamically start **/
let paymentTypes = [];
$("#payment_type option").each(function () {
    paymentTypes.push({ id: $(this).val(), name: $(this).text() });
});

// Delete button SVG
const deleteBtnSVG = `
<button type="button" class="delete-btn">
  <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.4519 4.12476L14.9633 11.6436C14.8384 13.5646 14.7761 14.5251 14.2699 15.2157C14.0195 15.5571 13.6974 15.8452 13.3236 16.0618C12.5678 16.4998 11.5561 16.4998 9.53271 16.4998C7.50669 16.4998 6.49366 16.4998 5.73733 16.0609C5.3634 15.844 5.04108 15.5554 4.79088 15.2134C4.28485 14.5217 4.2238 13.5598 4.10171 11.6362L3.625 4.12476" stroke="#C52127" stroke-width="1.25" stroke-linecap="round"/>
    <path d="M7.1731 8.80115H11.9039" stroke="#C52127" stroke-width="1.25" stroke-linecap="round"/>
    <path d="M8.35571 11.7405H10.7211" stroke="#C52127" stroke-width="1.25" stroke-linecap="round"/>
    <path d="M2.44238 4.12524H16.6347M12.7361 4.12524L12.1979 3.06904C11.8404 2.36744 11.6615 2.01663 11.3532 1.79785C11.2848 1.74932 11.2124 1.70615 11.1366 1.66877C10.7951 1.50024 10.3853 1.50024 9.56558 1.50024C8.72532 1.50024 8.30522 1.50024 7.95806 1.67583C7.88112 1.71475 7.8077 1.75967 7.73856 1.81012C7.4266 2.03777 7.25234 2.40141 6.90383 3.12869L6.42627 4.12524" stroke="#C52127" stroke-width="1.25" stroke-linecap="round"/>
  </svg>
</button>
`;

// Generate select HTML dynamically
function generatePaymentSelect(index) {
    let options = paymentTypes.map(pt => `<option value="${pt.id}">${pt.name}</option>`).join('');
    return `<select name="payment_types[${index}][payment_type_id]" class="form-select">${options}</select>`;
}

// Attach delete button
function attachDelete(paymentGrid) {
    paymentGrid.find(".delete-btn").off("click").on("click", function () {
        paymentGrid.remove();
        checkRestoreOriginalSelect();
        updateReceiveAmountFromGrids();
    });
}

// Attach amount input handler
function attachAmountChange(amountInput) {
    amountInput.on("input", function () {
        updateReceiveAmountFromGrids();
    });
}

// Update receive_amount from grids
function updateReceiveAmountFromGrids() {
    let grids = $(".payment-main-container .payment-grid");
    let total = 0;
    grids.each(function () {
        total += parseFloat($(this).find(".amount").val()) || 0;
    });
    $("#receive_amount").val(total).trigger("input");
}

// Restore original select if all dynamic grids removed
function checkRestoreOriginalSelect() {
    let paymentMain = $(".payment-main-container");
    let grids = paymentMain.find(".payment-grid");

    let dynamicGrids = grids.filter(function () {
        return $(this).find(".delete-btn").length > 0;
    });

    if (dynamicGrids.length === 0) {
        $("#payment_type").show();
        $("#receive_amount").prop("readonly", false);
        grids.remove();
    }
}

// Add payment button click
$(document).on("click", ".add-payment-btn", function (e) {
    e.preventDefault();
    let paymentMain = $(".payment-main-container");
    let existingCount = paymentMain.find(".payment-grid").length;

    if (existingCount === 0) {
        $("#payment_type").hide();
        for (let i = 0; i < 2; i++) {
            let deleteButton = i === 0 ? '' : deleteBtnSVG;
            let paymentGrid = $(`
                <div class="payment-grid">
                    ${generatePaymentSelect(i)}
                    <input name="payment_types[${i}][amount]" class="amount form-control" type="number" step="any" min="0" value="0">
                    ${deleteButton}
                </div>
            `);
            paymentMain.append(paymentGrid);
            attachDelete(paymentGrid);
            attachAmountChange(paymentGrid.find(".amount"));
        }

        let receiveVal = parseFloat($("#receive_amount").val()) || 0;
        paymentMain.find(".payment-grid").first().find(".amount").val(receiveVal);
        $("#receive_amount").prop("readonly", true);
        updateReceiveAmountFromGrids();
        return;
    }

    // Add new dynamic grid
    let index = paymentMain.find(".payment-grid").length;
    let paymentGrid = $(`
        <div class="payment-grid">
            ${generatePaymentSelect(index)}
            <input name="payment_types[${index}][amount]" class="amount form-control" type="number" step="any" min="0" value="0">
            ${deleteBtnSVG}
        </div>
    `);

    paymentMain.append(paymentGrid);
    attachDelete(paymentGrid);
    attachAmountChange(paymentGrid.find(".amount"));
    updateReceiveAmountFromGrids();
});

// On page load: for edit mode
$(document).ready(function () {
    let paymentMain = $(".payment-main-container");
    let existingGrids = paymentMain.find(".payment-grid");

    if (existingGrids.length > 0) {
        $("#payment_type").hide();
        $("#receive_amount").prop("readonly", true);

        existingGrids.each(function (i) {
            $(this).find("select").attr("name", `payment_types[${i}][payment_type_id]`);
            $(this).find("input.amount").attr("name", `payment_types[${i}][amount]`);

            if (i === 0) {
                $(this).find(".delete-btn").remove(); // first grid no delete
            }

            attachDelete($(this));
            attachAmountChange($(this).find(".amount"));
        });

        updateReceiveAmountFromGrids();
    }
});

// View Sale Payments Start
$(".sale-payment-view").on("click", function () {
    const saleId = $(this).data("id");
    const $tableBody = $("#sale-payments-data");
    $tableBody.empty();

    let url = $("#sale-payment-view-url").val();
    url = url.replace("SALE_ID", saleId);

    $.get(url, function (res) {
        if (res.payments && res.payments.length > 0) {
            res.payments.forEach((payment) => {
                const row = `<tr>
                    <td>${payment.created_at ?? ""}</td>
                    <td>${payment.ref_code ?? ""}</td>
                    <td>${payment.amount ?? ""}</td>
                    <td>${payment.payment_type ?? ""}</td>
                </tr>`;
                $tableBody.append(row);
            });
        } else {
            $tableBody.append(
                `<tr><td colspan="4" class="text-center text-muted">No payment data available</td></tr>`
            );
        }

        $("#view-sale-payment-modal").modal("show");
    });
});
// View Sale Payments End

// View Purchase Payments Start
$(".purchase-payment-view").on("click", function () {
    const purchaseId = $(this).data("id");
    const $tableBody = $("#purchase-payments-data");
    $tableBody.empty();

    let url = $("#purchase-payment-view-url").val();
    url = url.replace("PURCHASE_ID", purchaseId);

    $.get(url, function (res) {
        if (res.payments && res.payments.length > 0) {
            res.payments.forEach((payment) => {
                const row = `<tr>
                    <td>${payment.created_at ?? ""}</td>
                    <td>${payment.ref_code ?? ""}</td>
                    <td>${payment.amount ?? ""}</td>
                    <td>${payment.payment_type ?? ""}</td>
                </tr>`;
                $tableBody.append(row);
            });
        } else {
            $tableBody.append(
                `<tr><td colspan="4" class="text-center text-muted">No payment data available</td></tr>`
            );
        }

        $("#view-purchase-payment-modal").modal("show");
    });
});
// View Purchase Payments End










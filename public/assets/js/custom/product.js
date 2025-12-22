"use strict";

$("#category-select").on("change", function () {
    // Get selected category and its data attributes
    var selectedCategory = $(this).find("option:selected");
    var capacity = parseInt(selectedCategory.data("capacity"));
    var color = parseInt(selectedCategory.data("color"));
    var size = parseInt(selectedCategory.data("size"));
    var type = parseInt(selectedCategory.data("type"));
    var weight = parseInt(selectedCategory.data("weight"));

    $("#dynamic-fields").empty();

    // Conditionally add fields only if they exist in the database
    if (capacity === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Capacity</label><input type="text" name="capacity" class="form-control" placeholder="Enter capacity"></div>'
        );
    }
    if (color === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Color</label><input type="text" name="color" class="form-control" placeholder="Enter color"></div>'
        );
    }
    if (size === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Size</label><input type="text" name="size" class="form-control" placeholder="Enter size"></div>'
        );
    }
    if (type === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Type</label><input type="text" name="type" class="form-control" placeholder="Enter type"></div>'
        );
    }
    if (weight === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Weight</label><input type="text" name="weight" class="form-control" placeholder="Enter weight"></div>'
        );
    }
});

$(document).ready(function () {
    // Initial check if category is pre-selected
    var initialCategory = $("#category-select-edit").find("option:selected");
    handleCategoryChange(initialCategory);

    // Handle category selection change
    $("#category-select-edit").change(function () {
        var selectedCategory = $(this).find("option:selected");
        handleCategoryChange(selectedCategory);
    });

    function handleCategoryChange(selectedCategory) {
        // Get selected category and its data attributes
        var capacity = parseInt(selectedCategory.data("capacity"));
        var color = parseInt(selectedCategory.data("color"));
        var size = parseInt(selectedCategory.data("size"));
        var type = parseInt(selectedCategory.data("type"));
        var weight = parseInt(selectedCategory.data("weight"));

        // Clear existing dynamic fields
        $("#dynamic-fields-edit").empty();

        // Conditionally add fields only if they exist for the selected category
        if (capacity === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Capacity</label>
                    <input type="text" name="capacity" class="form-control" placeholder="Enter capacity" value="${$(
                "#capacity-value"
            ).val()}">
                </div>
            `);
        }
        if (color === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control" placeholder="Enter color" value="${$(
                "#color-value"
            ).val()}">
                </div>
            `);
        }
        if (size === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Size</label>
                    <input type="text" name="size" class="form-control" placeholder="Enter size" value="${$(
                "#size-value"
            ).val()}">
                </div>
            `);
        }
        if (type === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Type</label>
                    <input type="text" name="type" class="form-control" placeholder="Enter type" value="${$(
                "#type-value"
            ).val()}">
                </div>
            `);
        }
        if (weight === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Weight</label>
                    <input type="text" name="weight" class="form-control" placeholder="Enter weight" value="${$(
                "#weight-value"
            ).val()}">
                </div>
            `);
        }
    }
});

// $(".product-view").on("click", function () {
//     $("#product_name").text($(this).data("name"));
//     $("#product_code").text($(this).data("code"));
//     $("#product_brand").text($(this).data("brand"));
//     $("#product_category").text($(this).data("category"));
//     $("#product_unit").text($(this).data("unit"));
//     $("#product_purchase_price").text($(this).data("purchase-price"));
//     $("#product_sale_price").text($(this).data("sale-price"));
//     $("#product_wholesale_price").text($(this).data("wholesale-price"));
//     $("#product_dealer_price").text($(this).data("dealer-price"));
//     $("#product_stock").text($(this).data("stock"));
//     $("#product_low_stock").text($(this).data("low-stock"));
//     $("#expire_date").text($(this).data("expire-date"));
//     $("#product_manufacturer").text($(this).data("manufacturer"));

//     const product_image = $(this).data("image");
//     $("#product_image").attr("src", product_image);
// });


$(".product-view").on("click", function () {
    $("#product_name").text($(this).data("name"));
    $("#product_code").text($(this).data("code"));
    $("#product_brand").text($(this).data("brand"));
    $("#product_category").text($(this).data("category"));
    $("#product_unit").text($(this).data("unit"));
    $("#product_purchase_price").text($(this).data("purchase-price"));
    $("#product_sale_price").text($(this).data("sale-price"));
    $("#product_wholesale_price").text($(this).data("wholesale-price"));
    $("#product_dealer_price").text($(this).data("dealer-price"));
    $("#product_stock").text($(this).data("stock"));
    $("#product_low_stock").text($(this).data("low-stock"));
    $("#product_expire_date").text($(this).data("product-expire-date"));
    $("#product_manufacturer").text($(this).data("manufacturer"));

    const product_image = $(this).data("image");
    $("#product_image").attr("src", product_image);

    const stocks = $(this).data("stocks");
    const $tableBody = $("#stocks_table");
    $tableBody.empty();

    if (Array.isArray(stocks) && stocks.length > 0) {
        stocks.forEach((batch) => {
            const row = `<tr>
                <td>${batch.batch_no ?? "N/A"}</td>
                <td>${batch.productStock ?? 0}</td>
                <td>${batch.productSalePrice ?? 0}</td>
                <td>${batch.expire_date ?? "-"}</td>
            </tr>`;
            $tableBody.append(row);
        });
    } else {
        $tableBody.append(
            `<tr><td colspan="4" class="text-center text-muted">No batch data available</td></tr>`
        );
    }
});

$(".stock-view-data").on("click", function () {
    const stocks = $(this).data("stocks");
    const $tableBody = $("#stocks-table-data");
    $tableBody.empty();

    if (Array.isArray(stocks) && stocks.length > 0) {
        stocks.forEach((batch) => {
            const row = `<tr>
                <td>${batch.batch_no ?? "N/A"}</td>
                <td>${batch.productStock ?? 0}</td>
                <td>${batch.productPurchasePrice ?? 0}</td>
                <td>${batch.productSalePrice ?? 0}</td>
                <td>${batch.productWholeSalePrice ?? 0}</td>
                <td>${batch.productDealerPrice ?? 0}</td>
                <td class="text-danger">${batch.expire_date ?? ""}</td>
            </tr>`;
            $tableBody.append(row);
        });
    } else {
        $tableBody.append(
            `<tr><td colspan="8" class="text-center text-muted">No batch data available</td></tr>`
        );
    }

    $("#stock-modal-view").modal("show");
});


// product img upload code start
$(document).ready(function () {
    $(".upload-box").each(function () {
        if ($(this).find(".preview-wrapper").length > 0) {
            $(this).find("svg").first().hide();
            $(this).find(".upload-text").hide();
        }
    });
});

$(document).on("change", ".handle-image-Upload", function (e) {
    const input = this;
    const file = input.files[0];
    if (!file) return;

    const $box = $(input).closest(".upload-box");

    $box.find("svg").first().hide();
    $box.find(".upload-text").hide();

    $box.find(".preview-wrapper").remove();

    const previewURL = URL.createObjectURL(file);
    const previewHTML = `
        <div class="preview-wrapper">
            <img class="preview-img" src="${previewURL}">
            <span class="close-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4L4 12" stroke="#C52127" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 4L12 12" stroke="#C52127" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </div>
    `;

    $box.append(previewHTML).addClass("uploaded");
});

$(document).on("click", ".close-icon", function () {
    const $box = $(this).closest(".upload-box");
    $box.find(".preview-wrapper").remove();
    $box.find("input[type='file']").val("");
    $box.find("svg").first().show();
    $box.find(".upload-text").show();

    $box.removeClass("uploaded");
});

// product img upload code end

// variant wise input field change
const $singleRadio = $("#singleOption");
const $variantRadio = $("#variantOption");
const $singleContainer = $(".single-container");
const $variantContainer = $(".variant-container");

function toggleContainers() {
    if ($singleRadio.is(":checked")) {
        $singleContainer.show();
        $variantContainer.hide();

        // Disable and clear multiple variant fields
        $variantContainer.find("input, select").prop("disabled", true);
        $singleContainer.find("input, select").prop("disabled", false);
    } else {
        $singleContainer.hide();
        $variantContainer.show();

        // Disable and clear single variant fields
        $singleContainer.find("input, select").prop("disabled", true);
        $variantContainer.find("input, select").prop("disabled", false);
    }
}

toggleContainers();

$singleRadio.on("change", toggleContainers);
$variantRadio.on("change", toggleContainers);

$(document).on("click", ".add-variant-btn", function (e) {
    e.preventDefault();

    let index = $("#product-data tr").length;
    let permissions = {};

    $(".module-permission").each(function () {
        permissions[$(this).data("key")] = $(this).val() == "1";
    });

    let newRow = "<tr>";

    if (permissions.show_batch_no) {
        newRow += `<td><input type="text" name="stocks[${index}][batch_no]" class="form-control form-control-sm custom-table-input" placeholder="25632"></td>`;
    }
    if (permissions.show_product_stock) {
        newRow += `<td><input type="number" step="any" min="0" name="stocks[${index}][productStock]" class="form-control form-control-sm custom-table-input" placeholder="3"></td>`;
    }
    if (permissions.show_exclusive_price) {
        newRow += `<td><input type="number" step="any" min="0" name="stocks[${index}][exclusive_price]" class="form-control form-control-sm custom-table-input exclusive_price" placeholder="Ex: 50"></td>`;
    }
    if (permissions.show_inclusive_price) {
        newRow += `<td><input type="number" step="any" min="0" name="stocks[${index}][inclusive_price]" class="form-control form-control-sm custom-table-input inclusive_price" placeholder="Ex: 50"></td>`;
    }
    if (permissions.show_profit_percent) {
        newRow += `<td><input type="number" step="any" name="stocks[${index}][profit_percent]" class="form-control form-control-sm custom-table-input profit_percent" placeholder="25%"></td>`;
    }
    if (permissions.show_product_sale_price) {
        newRow += `<td><input type="number" step="any" min="0" name="stocks[${index}][productSalePrice]" class="form-control form-control-sm custom-table-input productSalePrice" placeholder="Ex: 200"></td>`;
    }
    if (permissions.show_product_wholesale_price) {
        newRow += `<td><input type="number" step="any" min="0" name="stocks[${index}][productWholeSalePrice]" class="form-control form-control-sm custom-table-input" placeholder="Ex: 200"></td>`;
    }
    if (permissions.show_product_dealer_price) {
        newRow += `<td><input type="number" step="any" min="0" name="stocks[${index}][productDealerPrice]" class="form-control form-control-sm custom-table-input" placeholder="Ex: 200"></td>`;
    }
    if (permissions.show_mfg_date) {
        newRow += `<td><input type="date" name="stocks[${index}][mfg_date]" class="form-control"></td>`;
    }
    if (permissions.show_expire_date) {
        newRow += `<td><input type="date" name="stocks[${index}][expire_date]" class="form-control"></td>`;
    }
    if (permissions.show_action) {
        newRow += `<td><a href="#" class="text-danger remove-row"><i class="fal fa-times fa-lg"></i></a></td>`;
    }

    newRow += "</tr>";

    $("#product-data").append(newRow);
});

// Calculation logic

// Get VAT rate
function getVatRate() {
    let $activeContainer = $singleRadio.is(":checked")
        ? $singleContainer
        : $variantContainer;
    return (
        parseFloat(
            $activeContainer.find("#vat_id option:selected").data("vat_rate")
        ) || 0
    );
}

// Get VAT type (inclusive/exclusive)
function getVatType() {
    let $activeContainer = $singleRadio.is(":checked")
        ? $singleContainer
        : $variantContainer;
    return $activeContainer.find("#vat_type").val();
}

// Get profit calculation type (markup/margin)
function getProfitOption() {
    return $("#profit_option").val();
}

// Update inclusive_price field based on VAT
function updateInclusiveFromExclusive($row) {
    const vatRate = getVatRate();

    const exclusiveInput = $row.find(".exclusive_price");
    const inclusiveInput = $row.find(".inclusive_price");

    let exclusive = parseFloat(exclusiveInput.val()) || 0;

    // Always add VAT to exclusive price
    inclusiveInput.val((exclusive + (exclusive * vatRate) / 100).toFixed(2));
}

// Calculate MRP from cost and profit
function calculateMrpRow($row) {
    const vatRate = getVatRate();
    const vatType = getVatType();
    const profitOption = getProfitOption();

    const costInput = $row.find(".exclusive_price");
    const profitInput = $row.find(".profit_percent");
    const saleInput = $row.find(".productSalePrice");

    let cost = parseFloat(costInput.val()) || 0;
    let profit = parseFloat(profitInput.val()) || 0;

    updateInclusiveFromExclusive($row);

    if (cost > 0) {
        let basePrice = cost;

        if (vatType === "inclusive") {
            basePrice += (cost * vatRate) / 100;
        }

        let mrp = 0;
        if (profitOption === "margin") {
            mrp = basePrice / (1 - profit / 100);
        } else {
            mrp = basePrice + (basePrice * profit) / 100;
        }

        saleInput.val(mrp.toFixed(2));
    }
}

// Calculate profit from MRP
function calculateProfitFromMrp($row) {
    const vatRate = getVatRate();
    const vatType = getVatType();
    const profitOption = getProfitOption();

    const costInput = $row.find(".exclusive_price");
    const profitInput = $row.find(".profit_percent");
    const saleInput = $row.find(".productSalePrice");

    let cost = parseFloat(costInput.val()) || 0;
    let mrp = parseFloat(saleInput.val()) || 0;

    updateInclusiveFromExclusive($row);

    if (cost > 0 && mrp > 0) {
        let basePrice = cost;

        if (vatType === "inclusive") {
            basePrice += (cost * vatRate) / 100;
        }

        let profit = 0;
        if (profitOption === "margin") {
            profit = ((mrp - basePrice) / mrp) * 100;
        } else {
            profit = ((mrp - basePrice) / basePrice) * 100;
        }

        profitInput.val(profit.toFixed(2));
    }
}

function updateExclusiveFromInclusive($row) {
    const vatRate = getVatRate();

    const inclusiveInput = $row.find(".inclusive_price");
    const exclusiveInput = $row.find(".exclusive_price");

    let inclusive = parseFloat(inclusiveInput.val()) || 0;

    // Reverse VAT: exclusive = inclusive / (1 + VAT%)
    let exclusive = inclusive / (1 + vatRate / 100);
    exclusiveInput.val(exclusive.toFixed(2));

    // Recalculate MRP and profit
    calculateMrpRow($row);
}

// Bind events for real-time calculation
function bindMrpCalculation() {
    $(document).on(
        "input change",
        ".exclusive_price, .profit_percent",
        function () {
            const $row = $(this).closest("tr").length
                ? $(this).closest("tr")
                : $(this).closest(".row");
            calculateMrpRow($row);
        }
    );

    $(document).on("input change", ".productSalePrice", function () {
        const $row = $(this).closest("tr").length
            ? $(this).closest("tr")
            : $(this).closest(".row");
        calculateProfitFromMrp($row);
    });

    $("#vat_id, #vat_type").on("change", function () {
        $(".exclusive_price").each(function () {
            const $row = $(this).closest("tr").length
                ? $(this).closest("tr")
                : $(this).closest(".row");
            calculateMrpRow($row);
        });
    });

    // On inclusive price change, update exclusive and MRP after edit
    $(document).on("blur", ".inclusive_price", function () {
        const $row = $(this).closest("tr").length
            ? $(this).closest("tr")
            : $(this).closest(".row");
        updateExclusiveFromInclusive($row);
    });
}

bindMrpCalculation();

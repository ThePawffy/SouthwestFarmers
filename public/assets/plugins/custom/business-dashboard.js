"use strict";

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

let selectedRange = '7d';

function getDashboardData() {
    var url = $("#get-dashboard").val();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        data: {
            range: selectedRange
        },
        success: function (res) {
            $("#total_sales").text(res.total_sales);
            $("#today_sales").text(res.today_sales);
            $("#total_purchases").text(res.total_purchases);
            $("#today_purchases").text(res.today_purchases);
            $("#total_income").text(res.total_income);
            $("#today_income").text(res.today_income);
            $("#total_expense").text(res.total_expense);
            $("#today_expense").text(res.today_expense);
        },
    });
}

$(document).ready(function () {
    getDashboardData();

    $('.filter-tab').on('click', function (e) {
        e.preventDefault();
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');
        selectedRange = $(this).data('range');
        getDashboardData();
    });
});



let incomeExpenseChart;

function renderEarningChart(income, expense) {
    const data = {
        labels: ["Incomes", "Expenses"],
        datasets: [
            {
                data: [income, expense],
                backgroundColor: ["#34AD5D", "#FF635A"],
                borderWidth: 0,
            },
        ],
    };

    const config = {
        type: "doughnut",
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: "60%",
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: "#fff",
                    titleColor: "#000",
                    bodyColor: "#000",
                    displayColors: false,
                    borderWidth: 0,
                    caretSize: 0,
                    padding: 14,
                    cornerRadius: 22,
                    bodyFont: {
                        size: 14,
                        weight: "bold",
                    },
                    callbacks: {
                        label: function (context) {
                            const value = context.raw;
                            const dataset = context.dataset.data;
                            const total = dataset.reduce((a, b) => a + b, 0);
                            const percent = Math.round((value / total) * 100);
                            return percent + "%";
                        },
                        title: function () {
                            return "";
                        },
                    },
                },
            },
        },
    };

    if (incomeExpenseChart) {
        incomeExpenseChart.destroy();
    }

    incomeExpenseChart = new Chart(document.getElementById("incomeExpenseChart"), config);
}

function fetchEarningData() {
    const url = $('#earning-statistic').val();

    $.ajax({
        url: url,
        method: 'GET',
        data: {
            range: selectedRange
        },
        success: function (response) {
            let totalIncome = response.incomes.reduce((sum, i) => sum + parseFloat(i.total), 0);
            let totalExpense = response.expenses.reduce((sum, e) => sum + parseFloat(e.total), 0);

            if (totalIncome === 0 && totalExpense === 0) {
                totalIncome = 0.000001;
                totalExpense = 0.000001;
            }

            renderEarningChart(totalIncome, totalExpense);

            $('.profit-circle').next('p').find('span').text(`${currencyFormat(totalIncome / 1000, 'icon', 1)}K`);
            $('.loss-circle').next('p').find('span').text(`${currencyFormat(totalExpense / 1000, 'icon', 1)}K`);
        }
    });
}

$(document).ready(function () {
    fetchEarningData();

    $('.filter-tab').on('click', function (e) {
        e.preventDefault();
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');
        selectedRange = $(this).data('range');
        fetchEarningData();
    });
});


// Sales and purchase

let defineRange = '7d';
let salesPurchaseChart;

function renderSalesPurchaseChart(purchasesData, salesData) {
    const chartCanvas = document.getElementById("salesChart");
    const ctx = chartCanvas.getContext("2d");

    const purchasesBgGradient = ctx.createLinearGradient(0, 0, 0, chartCanvas.height);
    purchasesBgGradient.addColorStop(0, "rgba(42, 180, 249, 0.17)");
    purchasesBgGradient.addColorStop(1, "rgba(34, 201, 177, 0)");

    const salesBgGradient = ctx.createLinearGradient(0, 0, 0, chartCanvas.height);
    salesBgGradient.addColorStop(0, "rgba(248, 107, 35, 0.12)");
    salesBgGradient.addColorStop(1, "rgba(249, 190, 16, 0)");

    const purchasesGradient = ctx.createLinearGradient(0, 0, chartCanvas.width, 0);
    purchasesGradient.addColorStop(0, "#019934");
    purchasesGradient.addColorStop(1, "#019934");

    const salesGradient = ctx.createLinearGradient(0, 0, chartCanvas.width, 0);
    salesGradient.addColorStop(0, "#FF9500");
    salesGradient.addColorStop(1, "#FF9500");

    const labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    if (salesPurchaseChart) {
        salesPurchaseChart.destroy();
    }

    salesPurchaseChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Purchases",
                    data: purchasesData,
                    borderColor: purchasesGradient,
                    backgroundColor: purchasesBgGradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: "#019934",
                    pointRadius: 0,
                    pointHoverRadius: 5,
                },
                {
                    label: "Sales",
                    data: salesData,
                    borderColor: salesGradient,
                    backgroundColor: salesBgGradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: "#FF9500",
                    pointRadius: 0,
                    pointHoverRadius: 5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: "index",
                intersect: false,
            },
            plugins: {
                tooltip: {
                    backgroundColor: "#ffffff",
                    titleColor: "#000000",
                    bodyColor: "#000000",
                    borderColor: "#e5e7eb",
                    borderWidth: 1,
                    callbacks: {
                        label: function (context) {
                        const value = parseFloat(context.raw);
                        return `${context.dataset.label} : ${currencyFormat(value, 'icon', 2)}`;
                       },
                    },
                },
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: "#C2C6CE",
                        borderDash: [4, 4],
                    },
                    ticks: {
                        callback: function (value) {
                        return currencyFormat(value >= 1000 ? value / 1000 : value, 'icon', 0) + (value >= 1000 ? 'K' : '');
                        },
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                },
            },
        },
    });
}

function fetchSalesPurchasesData(range = '7d') {
    const url = $('#sales-purchases-statistic').val();

    $.ajax({
        url: url,
        method: 'GET',
        data: { range: range },
        success: function (response) {
            const monthlyPurchases = Array(12).fill(0);
            const monthlySales = Array(12).fill(0);

            response.purchases.forEach(item => {
                const index = new Date(`${item.month} 1, 2000`).getMonth();
                monthlyPurchases[index] = parseFloat(item.total);
            });

            response.sales.forEach(item => {
                const index = new Date(`${item.month} 1, 2000`).getMonth();
                monthlySales[index] = parseFloat(item.total);
            });

            const totalPurchase = monthlyPurchases.reduce((a, b) => a + b, 0);
            const totalSale = monthlySales.reduce((a, b) => a + b, 0);

            renderSalesPurchaseChart(monthlyPurchases, monthlySales);

            $('.purchase-circle').next('p').find('span').text(`${currencyFormat(totalPurchase / 1000, 'icon', 1)}K`);
            $('.sale-circle').next('p').find('span').text(`${currencyFormat(totalSale / 1000, 'icon', 1)}K`);

        }
    });
}

$(document).ready(function () {
    fetchSalesPurchasesData('7d');

    $(".filter-tab").on("click", function (e) {
        e.preventDefault();
        $(".filter-tab").removeClass("active");
        $(this).addClass("active");

        const range = $(this).data("range");
        defineRange = range;
        fetchSalesPurchasesData(range);
    });
});






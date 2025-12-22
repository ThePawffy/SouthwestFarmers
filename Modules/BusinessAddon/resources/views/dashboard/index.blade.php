@extends('businessAddon::layouts.master')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('main_content')
    @php
        $notStaff = auth()->user()->role != 'staff';
        $allPermission = (
            visible_permission('salesListPermission') ||
            visible_permission('purchaseListPermission') ||
            visible_permission('addIncomePermission') ||
            visible_permission('addExpensePermission') ||
            visible_permission('partiesPermission') ||
            visible_permission('productPermission') ||
            visible_permission('stockPermission')
        );

        $salePurchasePermission = (
            visible_permission('salesListPermission') ||
            visible_permission('purchaseListPermission')
        );

         $incomeExpensePermission = (
            visible_permission('addIncomePermission') ||
            visible_permission('addExpensePermission')
        );

         @endphp

    <div class="m-h-100">
        @if (env('DEMO_MODE'))
        <div class="">
            <div id="demoAlert" class="custom-alert mb-4 mx-4">
                 <span><b class="text-white">Note:</b> This is a demo account — data resets every hour for this account only. Some of module are disabled in this account, to get full access please please create your own account.</span>
                 <button type="button" class="btn-close" aria-label="Close"></button>
             </div>
        </div>
        @endif
        <div class="business-dashboard-header position-relative ">
            <div class="d-flex align-items-center justify-content-between dashboard-top-greeting">
                <div class="greeting">
                    <h3> {{__('Hi')}} , {{ Auth::user()->name }}</h3>
                    <p> {{__('This is your admin panel')}} </p>
                </div>
                @if ($notStaff || $allPermission)
                <div class="data-tab d-flex align-items-center justify-content-center gap-2">
                    <a href="#" class="filter-tab" data-range="all"> {{__('All Date')}} </a>
                    <a href="#" class="filter-tab" data-range="12m"> {{__('12 Months')}} </a>
                    <a href="#" class="filter-tab" data-range="30d"> {{__('30 Days')}} </a>
                    <a href="#" class="filter-tab active" data-range="7d"> {{__('7 Days')}} </a>
                </div>
                @endif
            </div>

            <div class="stat-main-container">
                @if ($notStaff || visible_permission('salesListPermission'))
                <div class="dashboard-stat-container">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 id="total_sales">$0</h3>
                            <p class="title"> {{__('Total Sales')}} </p>
                        </div>
                        <img src="{{ asset('assets/images/dashboard/sales.svg') }}" alt="">
                    </div>
                    <p class="bottom-pera"> <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.77466 1.79102C6.91809 1.73145 7.08041 1.73158 7.22388 1.79102L7.32544 1.84473C7.35765 1.86601 7.3878 1.89049 7.41528 1.91797L9.74829 4.25098L9.82349 4.34375C9.95275 4.53936 9.95295 4.79472 9.82349 4.99023L9.74829 5.08203C9.63409 5.19611 9.48361 5.25391 9.33325 5.25391C9.2208 5.25388 9.10784 5.22199 9.01001 5.15723L8.91821 5.08203L7.58716 3.75098V11.667C7.58699 11.9911 7.32438 12.2538 7.00024 12.2539C6.67601 12.2539 6.41253 11.9912 6.41235 11.667V3.75195L5.08228 5.08203C4.88151 5.2828 4.5711 5.3087 4.34302 5.1582L4.25122 5.08203C4.02179 4.85253 4.02175 4.48045 4.25122 4.25098L6.58423 1.91797L6.6731 1.84473C6.70488 1.82364 6.73926 1.80668 6.77466 1.79199V1.79102Z"
                                fill="#00AE1C" stroke="#00AE1C" stroke-width="0.3" />
                        </svg>
                        <span class="up-amount" id="today_sales">$0 </span> {{__('Today Sales')}}
                    </p>
                </div>
                @endif
                @if ($notStaff || visible_permission('purchaseListPermission'))
                <div class="dashboard-stat-container">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 id="total_purchases">$0</h3>
                            <p class="title"> {{__('Total Purchase')}} </p>
                        </div>
                        <img src="{{ asset('assets/images/dashboard/purchase.svg') }}" alt="">
                    </div>
                    <p class="bottom-pera"> <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.77466 1.79102C6.91809 1.73145 7.08041 1.73158 7.22388 1.79102L7.32544 1.84473C7.35765 1.86601 7.3878 1.89049 7.41528 1.91797L9.74829 4.25098L9.82349 4.34375C9.95275 4.53936 9.95295 4.79472 9.82349 4.99023L9.74829 5.08203C9.63409 5.19611 9.48361 5.25391 9.33325 5.25391C9.2208 5.25388 9.10784 5.22199 9.01001 5.15723L8.91821 5.08203L7.58716 3.75098V11.667C7.58699 11.9911 7.32438 12.2538 7.00024 12.2539C6.67601 12.2539 6.41253 11.9912 6.41235 11.667V3.75195L5.08228 5.08203C4.88151 5.2828 4.5711 5.3087 4.34302 5.1582L4.25122 5.08203C4.02179 4.85253 4.02175 4.48045 4.25122 4.25098L6.58423 1.91797L6.6731 1.84473C6.70488 1.82364 6.73926 1.80668 6.77466 1.79199V1.79102Z"
                                fill="#00AE1C" stroke="#00AE1C" stroke-width="0.3" />
                        </svg>
                        <span class="up-amount" id="today_purchases">$0 </span> {{__('Today Purchase')}}
                    </p>
                </div>
                @endif
                @if ($notStaff || visible_permission('addIncomePermission'))
                <div class="dashboard-stat-container">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 id="total_income">$0</h3>
                            <p class="title"> {{__('Total Income')}} </p>
                        </div>
                        <img src="{{ asset('assets/images/dashboard/income.svg') }}" alt="">
                    </div>
                    <p class="bottom-pera"> <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.77466 12.209C6.91809 12.2685 7.08041 12.2684 7.22388 12.209L7.32544 12.1553C7.35765 12.134 7.3878 12.1095 7.41528 12.082L9.74829 9.74902L9.82349 9.65625C9.95275 9.46064 9.95295 9.20528 9.82349 9.00977L9.74829 8.91797C9.63409 8.80389 9.48361 8.74609 9.33325 8.74609C9.2208 8.74612 9.10784 8.77801 9.01001 8.84277L8.91821 8.91797L7.58716 10.249V2.33301C7.58699 2.00888 7.32438 1.74621 7.00024 1.74609C6.67601 1.74609 6.41253 2.00881 6.41235 2.33301V10.248L5.08228 8.91797C4.88151 8.7172 4.5711 8.6913 4.34302 8.8418L4.25122 8.91797C4.02179 9.14747 4.02175 9.51955 4.25122 9.74902L6.58423 12.082L6.6731 12.1553C6.70488 12.1764 6.73926 12.1933 6.77466 12.208V12.209Z"
                                fill="#FF3B30" stroke="#FF3B30" stroke-width="0.3" />
                        </svg>

                        <span class="down-amount" id="today_income">$0 </span> {{__('Today Income')}}
                    </p>
                </div>
                @endif
                @if ($notStaff || visible_permission('addExpensePermission'))
                <div class="dashboard-stat-container">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 id="total_expense">$0</h3>
                            <p class="title"> {{__('Total Expense')}} </p>
                        </div>
                        <img src="{{ asset('assets/images/dashboard/expense.svg') }}" alt="">
                    </div>
                    <p class="bottom-pera"> <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.77466 1.79102C6.91809 1.73145 7.08041 1.73158 7.22388 1.79102L7.32544 1.84473C7.35765 1.86601 7.3878 1.89049 7.41528 1.91797L9.74829 4.25098L9.82349 4.34375C9.95275 4.53936 9.95295 4.79472 9.82349 4.99023L9.74829 5.08203C9.63409 5.19611 9.48361 5.25391 9.33325 5.25391C9.2208 5.25388 9.10784 5.22199 9.01001 5.15723L8.91821 5.08203L7.58716 3.75098V11.667C7.58699 11.9911 7.32438 12.2538 7.00024 12.2539C6.67601 12.2539 6.41253 11.9912 6.41235 11.667V3.75195L5.08228 5.08203C4.88151 5.2828 4.5711 5.3087 4.34302 5.1582L4.25122 5.08203C4.02179 4.85253 4.02175 4.48045 4.25122 4.25098L6.58423 1.91797L6.6731 1.84473C6.70488 1.82364 6.73926 1.80668 6.77466 1.79199V1.79102Z"
                                fill="#00AE1C" stroke="#00AE1C" stroke-width="0.3" />
                        </svg>
                        <span class="up-amount" id="today_expense">$0 </span> {{__('Today Expense')}}
                    </p>
                </div>
                @endif
            </div>
        </div>
        <div class="dashboard-main-content container-fluid">
            <div class="business-dashboard-chart-container">
                @if ($notStaff || $salePurchasePermission)
                <div class="business-dashboard-chart">
                    <div>
                        <div class="chart-header d-flex align-items-center justify-content-between">
                            <h3>{{ __('Statistic (Sales & Purchase)') }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-3 mb-2 mt-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="purchase-circle"></div>
                                <p> {{__('Purchase')}} : <span>$0</span></p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="sale-circle"></div>
                                <p> {{__('Sales')}} : <span>$0</span></p>
                            </div>
                        </div>
                        <div class="lossprofit-chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
                @endif
                @if ($notStaff || $incomeExpensePermission)
                <div class="business-dashboard-chart">
                    <div>
                        <div class="chart-header d-flex align-items-center justify-content-between">
                            <h3>{{ __('Earning Overview') }}</h3>
                        </div>
                        <div class="income-chart-container mt-4">
                            <canvas id="incomeExpenseChart"></canvas>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-3 mt-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="profit-circle"></div>
                                <p> {{__('Incomes')}} : <span>$0</span></p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="loss-circle"></div>
                                <p> {{__('Expenses')}} : <span>$0</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="top-expired-product-container">
                @if ($notStaff || visible_permission('partiesPermission'))
                <div class="business-chart-container">
                    <div class="d-flex align-items-center justify-content-between bottom-table-header">
                        <h4>{{ __('Top 5 Customer') }}</h4>
                        <a class="view-all-btn" href="{{ route('business.parties.index') }}">{{ __('View All') }}<svg
                                width="17" height="16" viewBox="0 0 17 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 12L10.5 8L6.5 4" stroke="#667085" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>

                    <div class="px-3">
                        @foreach ($top_customers as $top_customer)
                            <div
                                class="d-flex align-items-center justify-content-between top-expired-product-content mt-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($top_customer->image ?? 'assets/images/logo/no-image.jpg') }}"
                                        alt="">
                                    <div>
                                        <h6>{{ $top_customer->name }}</h6>
                                        <p>{{ $top_customer->phone }}</p>
                                    </div>
                                </div>
                                <h5>{{ currency_format($top_customer->total_amount, currency: business_currency()) }}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                    @if ($notStaff || visible_permission('productPermission'))
                <div class="business-chart-container">
                    <div class="d-flex align-items-center justify-content-between bottom-table-header">
                        <h4>{{ __('Top 5 Product') }}</h4>
                        <a class="view-all-btn" href="{{ route('business.products.index') }}">{{ __('View All') }}<svg
                                width="17" height="16" viewBox="0 0 17 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 12L10.5 8L6.5 4" stroke="#667085" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>

                    <div class="px-3">
                        @foreach ($top_products as $top_product)
                            <div
                                class="d-flex align-items-center justify-content-between top-expired-product-content mt-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($top_product->productPicture ?? 'assets/images/logo/no-image.jpg') }}"
                                        alt="">
                                    <div>
                                        <h6>{{ $top_product->productName }}</h6>
                                        <p> {{ $top_product->category->name ?? ''}}</p>
                                    </div>
                                </div>
                                <h5>{{ currency_format($top_product->price, currency: business_currency()) }}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @if ($notStaff || visible_permission('stockPermission'))
                <div class="business-chart-container ">
                    <div class="d-flex align-items-center justify-content-between bottom-table-header">
                        <h4>{{ __('Stock Alert') }}</h4>
                        <a class="view-all-btn" href="{{ route('business.stocks.index', ['alert_qty' => true]) }}"> {{__('View All')}}  <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 12L10.5 8L6.5 4" stroke="#667085" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <div class="table-responsive low-stock-table-content">
                        <table id="lowStock" class="table text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('SL.') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Alert Qty') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $stock->productName }}</td>
                                        <td class="alert-qty">{{ $stock->alert_qty }} Pcs</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $currency = business_currency();
    @endphp
    {{-- Hidden input fields to store currency details --}}
    <input type="hidden" id="currency_symbol" value="{{ $currency->symbol }}">
    <input type="hidden" id="currency_position" value="{{ $currency->position }}">
    <input type="hidden" id="currency_code" value="{{ $currency->code }}">

    <input type="hidden" value="{{ route('business.dashboard.data') }}" id="get-dashboard">
    <input type="hidden" value="{{ route('business.dashboard.earning') }}" id="earning-statistic">
    <input type="hidden" value="{{ route('business.dashboard.sales.purchases') }}" id="sales-purchases-statistic">
@endsection

@push('js')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/business-dashboard.js') }}"></script>
@endpush

@extends('businessAddon::layouts.master')

@section('title')
    {{ __('Pos Sale') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/calculator.css') }}">
@endpush

@section('main_content')
    <div class="container-fluid">
        <div class="sales-purchese-header-container">
            <form class="sales-header-form">
                <div class="sales-purchese-header">
                    <div class="input-grid">
                        <label class="due-label"> {{__('Date')}} </label>
                        <input type="datetime-local" name="saleDate" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                    <div class="input-grid">
                        <label> {{__('Previous Due')}} </label>
                        <input id="customer_prev_due" type="number" class="form-control" readonly>
                    </div>
                    <div class="input-grid-calculator">
                        <label> {{__('Calculator')}} </label>
                        <a href="#calculatorModal" data-bs-toggle="modal">
                            <div class="d-flex align-items-center justify-content-center">
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_3207_2353)"><path d="M13.933 0H2.06704C1.33706 0 0.7453 0.739696 0.7453 1.65217V18.3478C0.7453 19.2603 1.33706 20 2.06704 20H13.933C14.663 20 15.2547 19.2603 15.2547 18.3478V1.65217C15.2547 0.739696 14.663 0 13.933 0ZM5.0261 17.2109C5.0261 17.4626 4.86287 17.6667 4.66147 17.6667H2.81681C2.61542 17.6667 2.45219 17.4626 2.45219 17.2109V14.905C2.45219 14.6533 2.61542 14.4493 2.81681 14.4493H4.66147C4.86287 14.4493 5.0261 14.6533 5.0261 14.905V17.2109ZM5.0261 12.1094C5.0261 12.3612 4.86287 12.5652 4.66147 12.5652H2.81681C2.61542 12.5652 2.45219 12.3612 2.45219 12.1094V9.80365C2.45219 9.55191 2.61542 9.34787 2.81681 9.34787H4.66147C4.86287 9.34787 5.0261 9.55191 5.0261 9.80365V12.1094ZM9.28697 17.2109C9.28697 17.4626 9.1237 17.6667 8.92234 17.6667H7.07768C6.87629 17.6667 6.71306 17.4626 6.71306 17.2109V14.905C6.71306 14.6533 6.87629 14.4493 7.07768 14.4493H8.92234C9.12374 14.4493 9.28697 14.6533 9.28697 14.905V17.2109ZM9.28697 12.1094C9.28697 12.3612 9.12374 12.5652 8.92234 12.5652H7.07768C6.87629 12.5652 6.71306 12.3612 6.71306 12.1094V9.80365C6.71306 9.55191 6.87629 9.34787 7.07768 9.34787H8.92234C9.12374 9.34787 9.28697 9.55191 9.28697 9.80365V12.1094ZM13.5478 17.2109C13.5478 17.4626 13.3846 17.6667 13.1832 17.6667H11.3386C11.1372 17.6667 10.9739 17.4626 10.9739 17.2109V14.905C10.9739 14.6533 11.1372 14.4493 11.3386 14.4493H13.1832C13.3846 14.4493 13.5478 14.6533 13.5478 14.905V17.2109ZM13.5478 12.1094C13.5478 12.3612 13.3846 12.5652 13.1832 12.5652H11.3386C11.1372 12.5652 10.9739 12.3612 10.9739 12.1094V9.80365C10.9739 9.55191 11.1372 9.34787 11.3386 9.34787H13.1832C13.3846 9.34787 13.5478 9.55191 13.5478 9.80365V12.1094ZM13.5478 6.5877C13.5478 6.83943 13.3846 7.04348 13.1832 7.04348H2.81681C2.61542 7.04348 2.45219 6.83943 2.45219 6.5877V2.45578C2.45219 2.20404 2.61542 2 2.81681 2H13.1832C13.3846 2 13.5478 2.20404 13.5478 2.45578V6.5877Z" fill="#575764"/></g><defs><clipPath id="clip0_3207_2353"><rect width="16" height="20" fill="white"/></clipPath></defs></svg>
                            </div>
                        </a>
                    </div>
                    <div class="input-grid-invoice">
                        <label> {{__('Invoice')}} </label>
                        <input type="text" name="invoiceNumber" value="{{ $invoice_no }}" class="form-control" placeholder="{{ __('Invoice no') }}." readonly>
                    </div>
                    <div class="select-customer-lg">

                        <select required name="party_id" id="party_id" class="form-select customer-select choices-select" aria-label="Select Customer">
                            <option value="">{{ __('Select Customer') }}</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" data-type="{{ $customer->type }}" data-phone="{{ $customer->phone }}" data-due="{{ $customer->due }}">
                                    {{ $customer->name }}
                                    ({{ $customer->type }}{{ $customer->due ? ' ' . currency_format($customer->due, currency: business_currency()) : '' }}
                                    ){{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>

                        @if (auth()->user()->role != 'staff' || visible_permission('partiesPermission'))
                        <a type="button" href="#customer-create-modal" data-bs-toggle="modal">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_273_6059)"><path d="M11.9143 15.6286V14.1429C11.9143 13.3548 11.6013 12.599 11.044 12.0418C10.4868 11.4845 9.73099 11.1714 8.94291 11.1714H3.74291C2.95484 11.1714 2.19905 11.4845 1.6418 12.0418C1.08454 12.599 0.771484 13.3548 0.771484 14.1429V15.6286" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.34301 8.2C7.98409 8.2 9.31444 6.86964 9.31444 5.22857C9.31444 3.58749 7.98409 2.25714 6.34301 2.25714C4.70194 2.25714 3.37158 3.58749 3.37158 5.22857C3.37158 6.86964 4.70194 8.2 6.34301 8.2Z" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M14.8859 5.97144V10.4286" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M17.1144 8.20001H12.6572" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_273_6059"><rect width="17.8286" height="17.8286" fill="white" transform="translate(0.0286865 0.0285645)"/></clipPath></defs></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="grid sales-main-container">
            <div class="main-container">
                <!-- Products Header -->
                <div class="products-header">
                    <div class="container-fluid p-0">
                        <div class="row g-2  align-items-center ">
                            <div>
                                <!-- Search Input and Add Button -->
                                <form action="{{ route('business.sales.product-filter') }}" method="post"
                                      class="product-filter product-filter-form w-100" table="#products-list">
                                    @csrf
                                    <div class="search-product">
                                        <div>
                                            <select name="page" class="all_item">
                                                <option value="all"> {{__('All Items')}} </option>
                                                <option value="20"> {{__('20')}} </option>
                                                <option value="50"> {{__('50')}} </option>
                                                <option value="100"> {{__('100')}} </option>
                                            </select>
                                        </div>
                                        <div class="d-flex position-relative sale-pur-search">
                                            <input type="text" name="search" id="sale_product_search" class="form-control search-input" placeholder="{{ __('Search items name...') }}">

                                            @if (auth()->user()->role != 'staff' || visible_permission('productPermission'))
                                            <a href="{{ route('business.products.create') }}" class="create-product">
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.8232 6V22.3333" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.65616 14.166H21.9895" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>
                                            @endif
                                            <svg class="search-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.3353 20.47L17.529 16.629C18.8014 15.106 19.5714 13.143 19.5714 11C19.5714 6.175 15.6819 2.25 10.9006 2.25C6.11922 2.25 2.22974 6.175 2.22974 11C2.22974 15.825 6.11922 19.75 10.9006 19.75C13.0242 19.75 14.9694 18.973 16.4786 17.689L20.2848 21.53C20.4295 21.676 20.6198 21.75 20.8101 21.75C21.0003 21.75 21.1906 21.677 21.3353 21.53C21.6256 21.238 21.6256 20.763 21.3353 20.47ZM3.71616 11C3.71616 7.002 6.93873 3.75 10.9006 3.75C14.8624 3.75 18.0849 7.002 18.0849 11C18.0849 14.998 14.8624 18.25 10.9006 18.25C6.93873 18.25 3.71616 14.998 3.71616 11Z" fill="#171717"/></svg>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="products-container">
                    <div class=" scroll-card">
                        <div class="search-product-card products gap-2 @if (count($products) === 1) single-product @endif product-list-container" id="products-list">
                            @include('businessAddon::sales.product-list')
                        </div>
                    </div>
                </div>
            </div>
            <div class="sales-container">
                <form action="{{ route('business.sales.store') }}" method="post" enctype="multipart/form-data" class="sales_purchase_form">
                    @csrf
                    <div class="cart-payment">
                        <div class="product-table">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                    <tr>
                                        <th class="border table-background">{{ __('SL') }}</th>
                                        <th class="border table-background text-start">{{ __('Product') }}</th>
                                        <th class="border table-background">{{ __('Batch') }}</th>
                                        <th class="border table-background">{{ __('U. Price') }}</th>
                                        <th class="border table-background text-center">{{ __('Qty') }}</th>
                                        <th class="border table-background">{{ __('Price') }}</th>
                                        <th class="border table-background">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cart-list">
                                    @include('businessAddon::sales.cart-list')
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="hr-container">
                            <hr>
                        </div>

                        {{-- Make Payment Section start --}}
                        <div class="grid row py-3 payment-section">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="amount-info-container">
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Receive Amount') }}</h6>
                                        <input name="receive_amount" type="number" step="any" id="receive_amount" min="0" class="form-control" placeholder="0">
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Change Amount') }}</h6>
                                        <input type="number" step="any" id="change_amount" class="form-control" placeholder="0" readonly>
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Due Amount') }}</h6>
                                        <input type="number" step="any" id="due_amount" class="form-control" placeholder="0" readonly>
                                    </div>
                                    <div class="row amount-container mb-2">
                                        <h6 class="payment-title">{{ __('Payment Type') }}</h6>
                                        <div class="p-0">
                                            <!-- Original select for single payment -->
                                            <select name="payment_type_id" class="form-select" id='payment_type'>
                                                @foreach($payment_types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>

                                            <div class="payment-main-container">
                                                {{-- Dynamic grids will be appended here --}}
                                            </div>

                                            <button class="add-payment-btn">+ Add Payment</button>
                                        </div>
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Note') }}</h6>
                                        <input type="text" name="note" class="form-control" placeholder="{{ __('Type note...') }}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="payment-container mb-3 amount-info-container">
                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6>{{ __('Sub Total') }}</h6>
                                        <div>
                                            <h6 class="fw-bold text-end sub-total" id="sub_total">
                                                {{ currency_format(0, currency: business_currency()) }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Vat') }}</h6>
                                        <div class="col-6 w-100 d-flex justify-content-between gap-2">
                                            <div class="d-flex d-flex align-items-center gap-2">
                                                <select name="vat_id" class="form-select vat_select" id='form-ware'>
                                                    <option value="">{{ __('Select') }}</option>
                                                    @foreach($vats as $vat)
                                                        <option value="{{ $vat->id }}" data-rate="{{ $vat->rate }}">{{ $vat->name }}
                                                            ({{ $vat->rate }}%)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="number" step="any" name="vat_amount" id="vat_amount" min="0" class="form-control right-start-input" placeholder="{{ __('0') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Discount') }}</h6>
                                        <div class="col-6 w-100 d-flex justify-content-between gap-2">
                                            <div class="d-flex d-flex align-items-center gap-2">
                                                <select name="discount_type" class="form-select discount_type" id='form-ware'>
                                                    <option value="flat">{{ __('Flat') }}({{ business_currency()->symbol }})</option>
                                                    <option value="percent">{{ __('Percent (%)') }}</option>
                                                </select>
                                            </div>
                                            <input type="number" step="any" name="discountAmount" id="discount_amount" min="0" class="form-control right-start-input" placeholder="{{ __('0') }}">
                                        </div>
                                    </div>
                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Shipping Cost') }}</h6>
                                        <div class="col-12 ">
                                            <input type="number" step="any" name="shipping_charge" id="shipping_charge" class="form-control right-start-input" placeholder="{{__('0')}}">
                                        </div>
                                    </div>
                                    <div class=" d-flex align-items-center justify-content-between fw-bold">
                                        <div class="fw-bold">{{ __('Total Amount') }}</div>
                                        <h6 class='fw-bold' id="total_amount">
                                            {{ currency_format(0, currency: business_currency()) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row p-3 pt-0 g-3">
                            <div class=" col-lg-6">
                                <button class="save-btn cancel-sale-btn" data-route="{{ route('business.carts.remove-all') }}">{{ __('Cancel') }}</button>
                            </div>
                            <div class=" col-lg-6">
                                <button class="submit-btn payment-btn">{{ __('Save & Print') }}</button>
                            </div>
                        </div>
                        {{-- Make Payment Section end --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        $currency = business_currency();
        $rounding_amount_option = sale_rounding();
    @endphp
    <input type="hidden" id="currency_symbol" value="{{ $currency->symbol }}">
    <input type="hidden" id="currency_position" value="{{ $currency->position }}">
    <input type="hidden" id="currency_code" value="{{ $currency->code }}">
    <input type="hidden" id="get_product" value="{{ route('business.products.prices') }}">
    <input type="hidden" id="get-cart" value="{{ route('business.carts.index') }}">
    <input type="hidden" id="get-cart-data" value="{{ route('business.sales.cart-data') }}">
    <input type="hidden" id="clear-cart" value="{{ route('business.carts.remove-all') }}">
    <input type="hidden" id="cart-store-url" value="{{ route('business.carts.store') }}">
    <input type="hidden" id="rounding_amount_option" value="{{ $rounding_amount_option }}">

    <input type="hidden" id="get-by-category" value="{{ route('business.products.get-by-category') }}">
    <input type="hidden" id="selectedProductValue" name="selectedProductValue">
    <input type="hidden" id="asset_base_url" value="{{ asset('') }}">
    <input type="hidden" id="get_stock_prices" value="{{ route('business.products.stocks-prices') }}">
    <input type="hidden" id="customer_wise_prices" value="{{ route('business.products.customer-prices') }}">

@endsection

@push('modal')
    @include('businessAddon::sales.calculator')
    @include('businessAddon::sales.customer-create')
    @include('businessAddon::sales.stock-list')
@endpush

@push('js')
    <script src="{{ asset('assets/js/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/sale.js') }}"></script>
    <script src="{{ asset('assets/js/custom/math.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/calculator.js') }}"></script>
@endpush

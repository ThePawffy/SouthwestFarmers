@extends('businessAddon::layouts.master')

@section('title')
    {{ __('Settings') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-bodys">

                    <div class="table-header p-16">
                        <h4>{{ __('Product Settings') }}</h4>
                        <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                            <input type="checkbox" class="custom-control-input delete-checkbox-item  multi-delete"
                                id="selectAll">
                            <label class="custom-control-label fw-bold" for="selectAll">{{ __('Select All') }}</label>
                        </div>
                    </div>
                    <div class="order-form-section p-16">

                        <form action="{{ route('business.product.setting.update') }}" method="post" class="ajaxform">
                            @csrf

                            <div class="row product-setting-form mt-3">
                                <div class="col-lg-4">
                                    <h3 class="title">{{ __('Add Product Settings') }}
                                        <svg class="svg" width="16" height="17" viewBox="0 0 16 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.8">
                                                <path
                                                    d="M7.99967 15.1615C11.6816 15.1615 14.6663 12.1767 14.6663 8.49479C14.6663 4.81289 11.6816 1.82812 7.99967 1.82812C4.31778 1.82812 1.33301 4.81289 1.33301 8.49479C1.33301 12.1767 4.31778 15.1615 7.99967 15.1615Z"
                                                    fill="#97979F" stroke="#97979F" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 5.82812V8.49479" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 11.1719H8.00833" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                    </h3>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_price" value="0">
                                        <input id="product_price" class="delete-checkbox-item  multi-delete" type="checkbox"
                                            name="show_product_price" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_price'] ?? false) ? 'checked' : '' }}>
                                        <label for="product_price">
                                            Product Price
                                        </label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_code" value="0">
                                        <input id="product_code" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_product_code" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_code'] ?? false) ? 'checked' : '' }}>
                                        <label for="product_code">Product Code</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_stock" value="0">
                                        <input id="stock" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_product_stock" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_stock'] ?? false) ? 'checked' : '' }}>
                                        <label for="stock">Product Stock</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_unit" value="0">
                                        <input id="unit" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_product_unit" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_unit'] ?? false) ? 'checked' : '' }}>
                                        <label for="unit">Product Unit</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_brand" value="0">
                                        <input id="brand" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_product_brand" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_brand'] ?? false) ? 'checked' : '' }}>
                                        <label for="brand">Product Brand</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_model_no" value="0">
                                        <input id="model" type="checkbox" class="delete-checkbox-item multi-delete"
                                            name="show_model_no" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_model_no'] ?? false) ? 'checked' : '' }}>
                                        <label for="model">Model No</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_category" value="0">
                                        <input id="category" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_product_category" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_category'] ?? false) ? 'checked' : '' }}>
                                        <label for="category">Product Category</label>
                                    </div>


                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_manufacturer" value="0">
                                        <input id="manufacturer" class="delete-checkbox-item multi-delete"
                                            type="checkbox" name="show_product_manufacturer" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_manufacturer'] ?? false) ? 'checked' : '' }}>
                                        <label for="manufacturer">Product Manufacturer</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_image" value="0">
                                        <input id="image" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_product_image" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_image'] ?? false) ? 'checked' : '' }}>
                                        <label for="image">Product Image</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_alert_qty" value="0">
                                        <input id="quantity" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_alert_qty" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_alert_qty'] ?? false) ? 'checked' : '' }}>
                                        <label for="quantity">Alert Quantity</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_vat_id" value="0">
                                        <input id="vat" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_vat_id" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_vat_id'] ?? false) ? 'checked' : '' }}>
                                        <label for="vat">VAT ID</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_vat_type" value="0">
                                        <input id="type" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_vat_type" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_vat_type'] ?? false) ? 'checked' : '' }}>
                                        <label for="type">VAT Type</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_exclusive_price" value="0">
                                        <input id="exclusive" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_exclusive_price" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_exclusive_price'] ?? false) ? 'checked' : '' }}>
                                        <label for="exclusive">Exclusive Price</label>
                                    </div>


                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_inclusive_price" value="0">
                                        <input id="inclusive" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_inclusive_price" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_inclusive_price'] ?? false) ? 'checked' : '' }}>
                                        <label for="inclusive">Inclusive Price</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_profit_percent" value="0">
                                        <input id="percent" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_profit_percent" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_profit_percent'] ?? false) ? 'checked' : '' }}>
                                        <label for="percent">Profit Percent</label>
                                    </div>


                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_action" value="0">
                                        <input id="color" class="delete-checkbox-item multi-delete" type="checkbox"
                                            name="show_action" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_action'] ?? false) ? 'checked' : '' }}>
                                        <label for="color">Action</label>
                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <h3 class="title">{{ __('Additional Product Field') }}
                                        <svg class="svg" width="16" height="17" viewBox="0 0 16 17"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.8">
                                                <path
                                                    d="M7.99967 15.1615C11.6816 15.1615 14.6663 12.1767 14.6663 8.49479C14.6663 4.81289 11.6816 1.82812 7.99967 1.82812C4.31778 1.82812 1.33301 4.81289 1.33301 8.49479C1.33301 12.1767 4.31778 15.1615 7.99967 15.1615Z"
                                                    fill="#97979F" stroke="#97979F" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 5.82812V8.49479" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 11.1719H8.00833" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                    </h3>

                                    <h6>{{ __('MRP/PRICE') }}</h6>
                                    <div class="additional-input">
                                        <div class="d-flex align-items-center mb-3">
                                            <input type="hidden" name="show_product_sale_price" value="0">
                                            <input id="mrp" type="checkbox"
                                                class="delete-checkbox-item multi-delete" name="show_product_sale_price"
                                                value="1"
                                                {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_sale_price'] ?? false) ? 'checked' : '' }}>
                                            <label for="mrp">MRP</label>
                                        </div>

                                        <input type="number" class="form-control additional-input-field"
                                            name="default_sale_price"
                                            value="{{ optional($product_setting)->modules['default_sale_price'] ?? '' }}"
                                            min="0" step="1" placeholder="{{ __('Enter Sale Price') }}">
                                    </div>


                                    <div class="additional-input">
                                        <div class="d-flex align-items-center mb-3">
                                            <input type="hidden" name="show_product_wholesale_price" value="0">
                                            <input id="wholesale" type="checkbox"
                                                class="delete-checkbox-item multi-delete"
                                                name="show_product_wholesale_price" value="1"
                                                {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_wholesale_price'] ?? false) ? 'checked' : '' }}>
                                            <label for="wholesale">Wholesale Price</label>
                                        </div>
                                        <input type="number" class="form-control additional-input-field"
                                            name="default_wholesale_price"
                                            value="{{ optional($product_setting)->modules['default_wholesale_price'] ?? '' }}"
                                            min="0" step="1"
                                            placeholder="{{ __('Enter Wholesale Price') }}">
                                    </div>

                                    <div class="additional-input">
                                        <div class="d-flex align-items-center mb-3">
                                            <input type="hidden" name="show_product_dealer_price" value="0">
                                            <input id="dealer" type="checkbox"
                                                class="delete-checkbox-item multi-delete" name="show_product_dealer_price"
                                                value="1"
                                                {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_dealer_price'] ?? false) ? 'checked' : '' }}>
                                            <label for="dealer">Dealer Price</label>
                                        </div>
                                        <input type="number" class="form-control additional-input-field"
                                            name="default_dealer_price"
                                            value="{{ optional($product_setting)->modules['default_dealer_price'] ?? '' }}"
                                            min="0" step="1" placeholder="{{ __('Enter Dealer Price') }}">
                                    </div>

                                    <h6>{{ __('Batch Tracking') }}</h6>

                                    <div class="additional-input">
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="hidden" name="show_batch_no" value="0">
                                            <input id="batch" type="checkbox"
                                                class="delete-checkbox-item multi-delete" name="show_batch_no"
                                                value="1"
                                                {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_batch_no'] ?? false) ? 'checked' : '' }}>
                                            <label for="batch">Batch No</label>
                                        </div>
                                        <input type="text" class="form-control additional-input-field"
                                            name="default_batch_no"
                                            value="{{ optional($product_setting)->modules['default_batch_no'] ?? '' }}"
                                            placeholder="{{ __('Batch No') }}">
                                    </div>

                                    {{-- Expiry Date --}}
                                    <div class="additional-input">
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="hidden" name="show_expire_date" value="0">
                                            <input id="expiry" type="checkbox"
                                                class="delete-checkbox-item multi-delete" name="show_expire_date"
                                                value="1"
                                                {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_expire_date'] ?? false) ? 'checked' : '' }}>
                                            <label for="expiry">Expiry Date</label>
                                        </div>

                                        <div class="">
                                            <select class="form-select date-type-selector" data-target="expired"
                                                name="expire_date_type">
                                                <option value="">Select</option>
                                                <option value="dmy"
                                                    {{ optional($product_setting->modules ?? null)['expire_date_type'] == 'dmy' ? 'selected' : '' }}>
                                                    Day / Month / Year</option>
                                                <option value="my"
                                                    {{ optional($product_setting->modules ?? null)['expire_date_type'] == 'my' ? 'selected' : '' }}>
                                                    Month / Year
                                                </option>
                                            </select>
                                        </div>

                                        <div class="expired-inputs">
                                            <input type="date" id="expired_dmy" name="default_expired_date_dmy"
                                                value="{{ optional($product_setting->modules ?? null)['expire_date_type'] == 'dmy' ? optional($product_setting->modules)['default_expired_date'] : '' }}"
                                                class="form-control expired-dmy"
                                                style="{{ optional($product_setting->modules ?? null)['expire_date_type'] == 'dmy' ? '' : 'display:none;' }}">

                                            <input type="month" id="expired_my" name="default_expired_date_my"
                                                value="{{ optional($product_setting->modules ?? null)['expire_date_type'] == 'my' ? optional($product_setting->modules)['default_expired_date'] : '' }}"
                                                class="form-control expired-my"
                                                style="{{ optional($product_setting->modules ?? null)['expire_date_type'] == 'my' ? '' : 'display:none;' }}">
                                        </div>

                                    </div>

                                    {{-- MFG Date --}}
                                    <div class="additional-input">
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="hidden" name="show_mfg_date" value="0">
                                            <input id="mfg" type="checkbox"
                                                class="delete-checkbox-item multi-delete" name="show_mfg_date"
                                                value="1"
                                                {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_mfg_date'] ?? false) ? 'checked' : '' }}>
                                            <label for="mfg">Mfg Date</label>
                                        </div>

                                        <div>
                                            <select class="form-select date-type-selector" data-target="mfg"
                                                name="mfg_date_type">
                                                <option value="">Select</option>
                                                <option value="dmy"
                                                    {{ optional($product_setting->modules ?? null)['mfg_date_type'] == 'dmy' ? 'selected' : '' }}>
                                                    Day / Month / Year
                                                </option>
                                                <option value="my"
                                                    {{ optional($product_setting->modules ?? null)['mfg_date_type'] == 'my' ? 'selected' : '' }}>
                                                    Month / Year
                                                </option>
                                            </select>
                                        </div>


                                        <div class="mfg-inputs">
                                            <input type="date" id="mfg_dmy" name="default_mfg_date_dmy"
                                                value="{{ optional($product_setting->modules ?? null)['mfg_date_type'] == 'dmy' ? optional($product_setting->modules)['default_mfg_date'] : '' }}"
                                                class="form-control mfg-dmy"
                                                style="{{ optional($product_setting->modules ?? null)['mfg_date_type'] == 'dmy' ? '' : 'display:none;' }}">

                                            <input type="month" id="mfg_my" name="default_mfg_date_my"
                                                value="{{ optional($product_setting->modules ?? null)['mfg_date_type'] == 'my' ? optional($product_setting->modules)['default_mfg_date'] : '' }}"
                                                class="form-control mfg-my"
                                                style="{{ optional($product_setting->modules ?? null)['mfg_date_type'] == 'my' ? '' : 'display:none;' }}">
                                        </div>

                                    </div>

                                    <h6>{{ __('Product Type') }}</h6>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_type_single" value="0">
                                        <input class="delete-checkbox-item  multi-delete" type="checkbox"
                                            name="show_product_type_single" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_type_single'] ?? false) ? 'checked' : '' }}>
                                        <label>
                                            Single
                                        </label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_type_variant" value="0">
                                        <input class="delete-checkbox-item  multi-delete" type="checkbox"
                                            name="show_product_type_variant" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_type_variant'] ?? false) ? 'checked' : '' }}>
                                        <label>
                                            Batch
                                        </label>
                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <h3 class="title">{{ __('Purchase Setting') }}
                                        <svg class="svg" width="16" height="17" viewBox="0 0 16 17"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.8">
                                                <path
                                                    d="M7.99967 15.1615C11.6816 15.1615 14.6663 12.1767 14.6663 8.49479C14.6663 4.81289 11.6816 1.82812 7.99967 1.82812C4.31778 1.82812 1.33301 4.81289 1.33301 8.49479C1.33301 12.1767 4.31778 15.1615 7.99967 15.1615Z"
                                                    fill="#97979F" stroke="#97979F" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 5.82812V8.49479" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 11.1719H8.00833" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                    </h3>
                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_batch_no" value="0">
                                        <input id="batch" type="checkbox" class="delete-checkbox-item multi-delete"
                                            name="show_product_batch_no" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_batch_no'] ?? false) ? 'checked' : '' }}>
                                        <label for="batch">{{ __('Batch No') }}</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <input type="hidden" name="show_product_expire_date" value="0">
                                        <input id="expire" type="checkbox" class="delete-checkbox-item multi-delete"
                                            name="show_product_expire_date" value="1"
                                            {{ is_null($product_setting) || is_null($product_setting->modules) || (optional($product_setting->modules)['show_product_expire_date'] ?? false) ? 'checked' : '' }}>
                                        <label for="expire">{{ __('Expire Date') }}</label>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="text-center mt-5">
                                        <button type="submit"
                                            class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

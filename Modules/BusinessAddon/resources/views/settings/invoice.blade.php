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
                        <h4>{{ __('Settings') }}</h4>
                    </div>
                    <div class="p-3">
                        <div class="row g-3">

                            <form action="{{ route('business.invoice.update') }}" method="post" class="invoice_form">
                                @csrf

                                <div class="row justify-content-center">
                                    <div class="col-lg-6 mb-4 text-center">
                                        <label class="invoice-option position-relative d-inline-block">
                                            <div class="invoice-size-radio">
                                                <div class="custom-radio">
                                                    <input type="radio" name="invoice_size" value="a4" {{ data_get($invoice_setting, 'value') == 'a4' ? 'checked' : 'checked' }}>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </div>
                                            <div class="mb-2">{{ __('Printer A4') }}</div>
                                            <img src="{{ asset('assets/images/logo/a4-invoice.png') }}" alt="A4 Invoice"
                                                class="img-fluid border rounded invoice-image ">
                                        </label>
                                    </div>

                                    <div class="col-lg-6 mb-4 text-center">
                                        <label class="invoice-option position-relative d-inline-block">
                                            <div class="invoice-size-radio">
                                                <div class="custom-radio">
                                                    <input type="radio" name="invoice_size" value="3_inch_80mm" {{ data_get($invoice_setting, 'value') == '3_inch_80mm' ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </div>
                                            <div class="mb-2">{{ __('Thermal: 3 inch 80mm') }}</div>
                                            <img src="{{ asset('assets/images/logo/3-inch-size-invoice.svg') }}"
                                                alt="80mm Invoice" class="img-fluid border rounded invoice-image">
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

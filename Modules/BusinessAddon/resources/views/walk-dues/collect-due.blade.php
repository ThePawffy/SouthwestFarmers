@extends('businessAddon::layouts.master')

@section('title')
    {{ __('Collect Due') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card border-0">
                <div class="card-bodys ">
                    <div class="table-header p-16">
                        <h4>{{ __('Collect Due') }}</h4>
                    </div>
                    <div class="order-form-section p-16">
                        <form action="{{ route('business.collect.walk.dues.store') }}" method="POST"
                            class="ajaxform">
                            @csrf
                            <div class="add-suplier-modal-wrapper d-block">
                                <div class="row">

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Select Invoice') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <input type="text" id="invoiceSelect" name="invoiceNumber" class="form-control w-100" value="{{ $walk_due->invoiceNumber }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Date') }}</label>
                                        <input type="datetime-local" name="paymentDate" required class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Total Amount') }}</label>
                                        <input type="number" id="totalAmount" value="{{ $walk_due->dueAmount }}" readonly
                                            class="form-control">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Due Amount') }}</label>
                                        <input type="number" id="dueAmount" value="{{ $walk_due->dueAmount }}"
                                            value="" readonly class="form-control">
                                    </div>


                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Paid Amount') }}</label>
                                        <input type="number" name="payDueAmount" id="paidAmount" required
                                            class="form-control">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Payment Type') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="payment_type_id" class="form-control table-select w-100 role"
                                                required>
                                                @foreach ($payment_types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <button type="reset"
                                                class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                            <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                                        </div>
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

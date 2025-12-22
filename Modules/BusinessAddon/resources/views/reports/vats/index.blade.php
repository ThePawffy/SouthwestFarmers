@extends('businessAddon::layouts.master')

@section('title')
    {{ __('Vat Reports') }}
@endsection

@section('main_content')
<div class="min-vh-100">
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">
                    <div class="tab-table-container">

                    <div class="table-header p-16 d-print-none">
                        <h4>{{ __('Vat Report List') }}</h4>
                    </div>
                    <div class="table-header justify-content-center border-0 d-none d-block d-print-block text-center">
                        @include('businessAddon::print.header')
                        <h4 class="mt-2">{{ __('Vat Report List') }}</h4>
                    </div>

                    <ul class="nav nav-tabs custom-tabs mt-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales" type="button" role="tab" aria-controls="sales" aria-selected="true">
                                {{ __('Sales') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="purchase-tab" data-bs-toggle="tab" data-bs-target="#purchase" type="button" role="tab" aria-controls="purchase" aria-selected="false">
                                {{ __('Purchases') }}
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3">
                        <!-- Sales tab -->
                        <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                            <div class="table-container responsive-table">
                                <table class="table dashboard-table-content bg-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-start striped-th">{{ __('Date') }}</th>
                                            <th class="text-center striped-th">{{ __('Invoice') }}</th>
                                            <th class="text-center striped-th">{{ __('Customer') }}</th>
                                            <th class="text-center striped-th">{{ __('Total Amount') }}</th>
                                            <th class="text-center striped-th">{{ __('Payment Method') }}</th>
                                            <th class="text-center striped-th">{{ __('Discount') }}</th>
                                            @foreach ($vats as $vat)
                                                <th class="text-center striped-th">{{ $vat->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td class="text-start table-data">{{ formatted_date($sale->created_at) }}</td>
                                                <td class="text-center table-data">{{ $sale->invoiceNumber }}</td>
                                                <td class="text-center table-data">{{ $sale->party->name ?? '' }}</td>
                                                <td class="text-center table-data">{{ currency_format($sale->totalAmount, currency: business_currency()) }}</td>
                                                <td class="text-center table-data">{{ $sale->payment_type->name ?? '' }}</td>
                                                <td class="text-center table-data">{{ currency_format($sale->discountAmount, currency: business_currency()) }}</td>
                                                @foreach ($vats as $vat)
                                                    <td class="text-center table-data">
                                                        {{ $sale->vat_id == $vat->id ? currency_format($sale->vat_amount, currency: business_currency()) : '0' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Purchase tab -->
                        <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                            <div class="table-container responsive-table">
                                <table class="table dashboard-table-content bg-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-start striped-th">{{ __('Date') }}</th>
                                            <th class="text-center striped-th">{{ __('Invoice') }}</th>
                                            <th class="text-center striped-th">{{ __('Supplier') }}</th>
                                            <th class="text-center striped-th">{{ __('Total Amount') }}</th>
                                            <th class="text-center striped-th">{{ __('Payment Method') }}</th>
                                            <th class="text-center striped-th">{{ __('Discount') }}</th>
                                            @foreach ($vats as $vat)
                                                <th class="text-center striped-th">{{ $vat->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchases as $purchase)
                                            <tr class="">
                                                <td class="text-start table-data">{{ formatted_date($purchase->created_at) }}</td>
                                                <td class="text-center table-data">{{ $purchase->invoiceNumber }}</td>
                                                <td class="text-center table-data">{{ $purchase->party->name ?? '' }}</td>
                                                <td class="text-center table-data">{{ currency_format($purchase->totalAmount, currency: business_currency()) }}</td>
                                                <td class="text-center table-data">{{ $purchase->payment_type->name ?? '' }}</td>
                                                <td class="text-center table-data">{{ currency_format($purchase->discountAmount, currency: business_currency()) }}</td>
                                                @foreach ($vats as $vat)
                                                    <td class="text-center table-data">
                                                        {{ $purchase->vat_id == $vat->id ? currency_format($purchase->vat_amount, currency: business_currency()) : '0' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('businessAddon::layouts.pdf.pdf_layout')

@section('pdf_title')
    <div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
        @include('businessAddon::print.header')
        <h4 class="mt-2">{{ __('Purchase Invoice') }}</h4>
    </div>

    @push('css')
        @include('businessAddon::pdf.css')
    @endpush
@endsection

@section('pdf_content')

    <div class="in-container">
        <div class="in-content">

            <div class="d-flex justify-content-between align-items-center gap-3 print-logo-container">
                <div class="d-flex align-items-center gap-2 logo">
                    @php
                        $logoPath = public_path(
                            get_business_option('business-settings')['invoice_logo'] ??
                                'assets/images/icons/default.svg',
                        );
                        $logoData = base64_encode(file_get_contents($logoPath));
                        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
                        $src = 'data:image/' . $logoType . ';base64,' . $logoData;
                    @endphp
                    <img class="invoice-logo" src="{{ $src }}" alt="Logo">
                    <div>
                        <h3 class="mb-0">{{ $purchase->business->companyName ?? '' }}</h3>
                    </div>

                    <h3 class="right-invoice ">{{ __('INVOICE') }}</h3>
                </div>

                <h3 class="right-invoice mb-0 align-self-center">{{ __('INVOICE') }}</h3>
            </div>

            <div class="invoice-header-content">
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Supplier Name') }}</td>
                                <td class="text-end">: {{ $purchase->party->name ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Mobile') }}</td>
                                <td class="text-end">: {{ $purchase->party->phone ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row ">
                                <td class="text-end">{{ __('Sales By') }}</td>
                                <td class="text-end">: {{ $purchase->user->name ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Invoice') }}</td>
                                <td class="text-end"> : {{ $purchase->invoiceNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Date') }}</td>
                                <td class="text-end">: {{ formatted_date($purchase->purchaseDate ?? '') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if (!$purchase_returns->isEmpty())
                @php
                    $subtotal = 0;
                    $total_return_amount = 0;
                @endphp

                {{-- Purchase Items --}}
                <div class="table-content">
                    <table class="table table-striped">
                        <thead>
                            <tr class="in-table-header">
                                <th class="head-red text-center">{{ __('SL') }}</th>
                                <th class="head-red text-start">{{ __('Item') }}</th>
                                <th class="head-black text-center">{{ __('Quantity') }}</th>
                                <th class="head-black text-end">{{ __('Unit Price') }}</th>
                                <th class="head-black text-end">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody class="in-table-body-container">
                            @foreach ($purchase->details as $detail)
                                @php
                                    $productTotal = ($detail->productPurchasePrice ?? 0) * ($detail->quantities ?? 0);
                                    $subtotal += $productTotal;
                                @endphp
                                <tr class="in-table-body">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $detail->product->productName ?? '' }}</td>
                                    <td class="text-center">{{ $detail->quantities ?? '' }}</td>
                                    <td class="text-end">
                                        {{ currency_format($detail->productPurchasePrice ?? 0, currency: business_currency()) }}
                                    </td>
                                    <td class="text-end">
                                        {{ currency_format($productTotal, currency: business_currency()) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Purchase Summary --}}
                <div class="in-bottom-content">
                    <div class="left-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-start">{{ __('Supplier Name') }}</td>
                                    <td class="text-start">: {{ $purchase->party->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start">{{ __('Mobile') }}</td>
                                    <td class="text-start">: {{ $purchase->party->phone ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start">{{ __('Payment Type') }}</td>
                                    <td class="text-start">:
                                        @if($purchase->paymentTypes && $purchase->paymentTypes->isNotEmpty())
                                        {{ $purchase->paymentTypes->pluck('name')->implode(', ') }}
                                        @else
                                            {{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="right-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-end">{{ __('Vat') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->vat_amount, currency: business_currency()) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end">{{ __('Shipping Charge') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->shipping_charge, currency: business_currency()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">{{ __('Discount') }}
                                        @if ($purchase->discount_type == 'percent')
                                            ({{ $purchase->discount_percent }}%)
                                        @endif
                                    </td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->discountAmount, currency: business_currency()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($subtotal + $purchase->vat_amount + $purchase->shipping_charge - $purchase->discountAmount, currency: business_currency()) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Return Table --}}
                <div>
                    <table class="table table-striped pdf-table">
                        <thead>
                            <tr class="in-table-header">
                                <th class="head-red text-center">{{ __('SL') }}</th>
                                <th class="head-red text-start">{{ __('Date') }}</th>
                                <th class="head-black text-start">{{ __('Returned Item') }}</th>
                                <th class="head-black text-center">{{ __('Quantity') }}</th>
                                <th class="head-black text-end">{{ __('Total Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody class="in-table-body-container">
                            @foreach ($purchase_returns as $return)
                                @foreach ($return->details as $detail)
                                    @php
                                        $return_amount = $detail->return_amount ?? 0;
                                        $total_return_amount += $return_amount;
                                    @endphp
                                    <tr class="in-table-body">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ formatted_date($return->return_date) }}</td>
                                        <td class="text-start">{{ $detail->purchaseDetail->product->productName ?? '' }}
                                        </td>
                                        <td class="text-center">{{ $detail->return_qty ?? 0 }}</td>
                                        <td class="text-end">
                                            {{ currency_format($return_amount, currency: business_currency()) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Return Summary --}}
                <div class="in-bottom-content">
                    <div class="left-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-start">{{ __('Payment Type') }} :
                                        @if($purchase->paymentTypes && $purchase->paymentTypes->isNotEmpty())
                                        {{ $purchase->paymentTypes->pluck('name')->implode(', ') }}
                                        @else
                                            {{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="right-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-end">{{ __('Total Return Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($total_return_amount, currency: business_currency()) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end total-amound">{{ __('Payable Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($purchase->totalAmount, currency: business_currency()) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end">{{ __('Paid Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->paidAmount, currency: business_currency()) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end">{{ __('Due') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->dueAmount, currency: business_currency()) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                {{-- Purchase Items --}}

                @php
                    $subtotal = 0;
                @endphp

                <div class="table-content">
                    <table class="table table-striped">
                        <thead>
                            <tr class="in-table-header">
                                <th class="head-red text-center">{{ __('SL') }}</th>
                                <th class="head-red text-start">{{ __('Item') }}</th>
                                <th class="head-black text-center">{{ __('Quantity') }}</th>
                                <th class="head-black text-end">{{ __('Unit Price') }}</th>
                                <th class="head-black text-end">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody class="in-table-body-container">
                            @foreach ($purchase->details as $detail)
                                @php
                                    $productTotal = ($detail->productPurchasePrice ?? 0) * ($detail->quantities ?? 0);
                                    $subtotal += $productTotal;
                                @endphp
                                <tr class="in-table-body">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $detail->product->productName ?? '' }}</td>
                                    <td class="text-center">{{ $detail->quantities ?? '' }}</td>
                                    <td class="text-end">
                                        {{ currency_format($detail->productPurchasePrice ?? 0, currency: business_currency()) }}
                                    </td>
                                    <td class="text-end">
                                        {{ currency_format($productTotal, currency: business_currency()) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Purchase Summary --}}
                <div class="in-bottom-content">
                    <div class="left-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-start">{{ __('Supplier Name') }}</td>
                                    <td class="text-start">: {{ $purchase->party->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start">{{ __('Mobile') }}</td>
                                    <td class="text-start">: {{ $purchase->party->phone ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start">{{ __('Payment Type') }}</td>
                                    <td class="text-start">:
                                        @if($purchase->paymentTypes && $purchase->paymentTypes->isNotEmpty())
                                        {{ $purchase->paymentTypes->pluck('name')->implode(', ') }}
                                        @else
                                            {{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="right-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-end">{{ __('Vat') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->vat_amount, currency: business_currency()) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end">{{ __('Shipping Charge') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->shipping_charge, currency: business_currency()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">{{ __('Discount') }}
                                        @if ($purchase->discount_type == 'percent')
                                            ({{ $purchase->discount_percent }}%)
                                        @endif
                                    </td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->discountAmount, currency: business_currency()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($subtotal + $purchase->vat_amount + $purchase->shipping_charge - $purchase->discountAmount, currency: business_currency()) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif


            <div class="pdf-footer">
                <div class="in-signature-container d-flex align-items-center justify-content-between my-3 px-2">
                    <div class="in-signature left-content">
                        <hr class="in-hr">
                        <h4>{{ __('Customer Signature') }}</h4>
                    </div>
                    <div class="in-signature right-content">
                        <hr class="in-hr">
                        <h4>{{ __('Authorized Signature') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

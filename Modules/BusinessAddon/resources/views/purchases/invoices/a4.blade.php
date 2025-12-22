<div class="invoice-container">
    <div class="invoice-content position-relative">
        <div
            class="row d-print-none py-2 d-flex align-items-start justify-content-between border-bottom print-container">

            <div class="col-md-6 d-flex align-items-center p-2">
                <span class="Money-Receipt">{{ __('Purchase Invoice') }}</span>
            </div>

            <div class="col-md-6 d-flex justify-content-end align-items-end">
                <div class="d-flex gap-2 ">
                    <form action="{{ route('business.purchases.mail', ['purchase_id' => $purchase->id]) }}"
                        method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <button type="submit" class="btn email-btn custom-print-btn"><svg width="20"
                                height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1.66602 5L7.42687 8.26414C9.55068 9.4675 10.448 9.4675 12.5718 8.26414L18.3327 5"
                                    stroke="white" stroke-width="1.5" stroke-linejoin="round" />
                                <path
                                    d="M1.67916 11.2295C1.73363 13.7842 1.76087 15.0614 2.70348 16.0077C3.64608 16.9538 4.95796 16.9868 7.58171 17.0527C9.19877 17.0933 10.7999 17.0933 12.417 17.0527C15.0408 16.9868 16.3526 16.9538 17.2953 16.0077C18.2378 15.0614 18.2651 13.7842 18.3195 11.2295C18.3371 10.4081 18.3371 9.59159 18.3195 8.77017C18.2651 6.21555 18.2378 4.93825 17.2953 3.99205C16.3526 3.04586 15.0408 3.0129 12.417 2.94698C10.7999 2.90635 9.19877 2.90635 7.5817 2.94697C4.95796 3.01289 3.64608 3.04585 2.70347 3.99205C1.76087 4.93824 1.73363 6.21555 1.67915 8.77017C1.66163 9.59159 1.66164 10.4081 1.67916 11.2295Z"
                                    stroke="white" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                            <span class="pl-1"> {{__('Email')}} </span>
                        </button>
                    </form>

                    <a class="print-btn-2 print-btn" onclick="window.print()"><svg width="21" height="20"
                            viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.62765 14.9998C4.85838 14.9998 3.97375 14.9998 3.34393 14.6222C2.93229 14.3753 2.60067 14.0224 2.38664 13.6033C2.05918 12.9621 2.1472 12.1143 2.32325 10.4186C2.47021 9.00309 2.54369 8.2953 2.90505 7.77551C3.14229 7.43425 3.46318 7.15454 3.83933 6.96111C4.41225 6.6665 5.15072 6.6665 6.62765 6.6665H14.371C15.848 6.6665 16.5864 6.6665 17.1594 6.96111C17.5355 7.15454 17.8564 7.43425 18.0937 7.77551C18.455 8.2953 18.5285 9.00309 18.6754 10.4186C18.8515 12.1143 18.9395 12.9621 18.612 13.6033C18.398 14.0224 18.0664 14.3753 17.6548 14.6222C17.0249 14.9998 16.1404 14.9998 14.371 14.9998"
                                stroke="white" stroke-width="1.5" />
                            <path
                                d="M14.6673 6.6665V4.99984C14.6673 3.42849 14.6673 2.64281 14.1792 2.15466C13.691 1.6665 12.9053 1.6665 11.334 1.6665H9.66732C8.09597 1.6665 7.31029 1.6665 6.82214 2.15466C6.33398 2.64281 6.33398 3.42849 6.33398 4.99984V6.6665"
                                stroke="white" stroke-width="1.5" stroke-linejoin="round" />
                            <path
                                d="M12.1579 13.3335H8.8434C8.27234 13.3335 7.98679 13.3335 7.74384 13.4242C7.41991 13.5452 7.14254 13.7802 6.95582 14.0917C6.81578 14.3255 6.74653 14.6261 6.60802 15.2272C6.39159 16.1664 6.28339 16.636 6.35698 17.0126C6.45511 17.5147 6.76096 17.9397 7.18609 18.1647C7.50493 18.3335 7.95109 18.3335 8.8434 18.3335H12.1579C13.0502 18.3335 13.4964 18.3335 13.8152 18.1647C14.2403 17.9397 14.5462 17.5147 14.6443 17.0126C14.7179 16.636 14.6097 16.1664 14.3933 15.2272C14.2548 14.6261 14.1855 14.3255 14.0455 14.0917C13.8587 13.7802 13.5814 13.5452 13.2575 13.4242C13.0145 13.3335 12.729 13.3335 12.1579 13.3335Z"
                                stroke="white" stroke-width="1.5" stroke-linejoin="round" />
                            <path d="M15.5 10H15.5075" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        {{ __('Print') }}</a>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center gap-3 print-logo-container">
            {{-- Left Side: Logo and Content --}}
            <div class="d-flex align-items-center gap-2 logo in-logo-container">
                <div class="invoice-logo">
                    <img class="invoice-logo" src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/icons/default.svg') ?? '' }}" alt="Logo">
                </div>
                <h4>{{ $purchase->business->companyName ?? 'Grocery Shop' }}</h4>
            </div>

            {{-- Right Side: Invoice --}}
            <h3 class="right-invoice ">{{ __('INVOICE') }}</h3>
        </div>

        <div class="d-flex align-items-start justify-content-between flex-wrap mt-3">
            <div>
                <table class="table">
                    <tbody>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Supplier Name') }}</td>
                            <td class="text-start ">: {{ $purchase->party->name ?? '' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Mobile') }}</td>
                            <td class="text-start">: {{ $purchase->party->phone ?? '' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Address') }}</td>
                            <td class="text-start">: {{ $purchase->party->address ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <table class="table">
                    <tbody>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Purchase By') }}</td>
                            <td class="text-start ">:
                                {{ $purchase->user->role != 'staff' ? 'Admin' : $purchase->user->name }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Invoice') }}</td>
                            <td class="text-start">: {{ $purchase->invoiceNumber ?? '' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Date') }}</td>
                            <td class="text-start">: {{ formatted_date($purchase->purchaseDate ?? '') }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start">{{ $purchase->business->vat_name ?? '' }}</td>
                            @if (!empty($purchase->business->vat_name))
                                <td class="text-start"> : {{ $purchase->business->vat_no ?? '' }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if (!$purchase_returns->isEmpty())
            {{-- purchases --}}
            <div class="custom-invoice-table">
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
                    @php
                        $subtotal = 0;
                    @endphp
                    <tbody class="in-table-body-container">
                        @foreach ($purchase->details as $detail)
                            @php
                                $productTotal =
                                    ($detail->productPurchasePrice ?? 0) * ($detail->quantities ?? 0);
                                $subtotal += $productTotal;
                            @endphp
                            <tr class="in-table-body">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    {{ ($detail->product->productName ?? '') . (!empty($detail->stock?->batch_no) ? ' (' . $detail->stock?->batch_no . ')' : '') }}
                                </td>
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
            <div class="d-flex align-items-center justify-content-between position-relative">
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start"></td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Subtotal') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($subtotal, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Vat') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->vat_amount, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Shipping Charge') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->shipping_charge, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Discount') }}
                                    @if ($purchase->discount_type == 'percent')
                                        ({{ $purchase->discount_percent }}%)
                                    @endif
                                </td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->discountAmount + $total_discount, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                <td class="text-end total-amound">:</td>
                                <td class="text-end total-amound">
                                    {{ currency_format($subtotal + $purchase->vat_amount - ($purchase->discountAmount + $total_discount) + $purchase->shipping_charge, currency: business_currency()) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- purchase Return --}}
            <div class="custom-invoice-table">
                <table class="table table-striped">
                    <thead>
                        <tr class="in-table-header">
                            <th class="head-red text-center">{{ __('SL') }}</th>
                            <th class="head-red text-start">{{ __('Date') }}</th>
                            <th class="head-black text-start">{{ __('Returned Item') }}</th>
                            <th class="head-black text-center">{{ __('Quantity') }}</th>
                            <th class="head-black text-end">{{ __('Total Amount') }}</th>
                        </tr>
                    </thead>
                    @php $total_return_amount = 0; @endphp
                    <tbody class="in-table-body-container">
                        @foreach ($purchase_returns as $key => $return)
                            @foreach ($return->details as $detail)
                                @php
                                    $total_return_amount += $detail->return_amount ?? 0;
                                @endphp
                                <tr class="in-table-body">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ formatted_date($return->return_date) }}</td>
                                    <td class="text-start">
                                        {{ $detail->purchaseDetail->product->productName ?? '' }}
                                    </td>
                                    <td class="text-center">{{ $detail->return_qty ?? 0 }}</td>
                                    <td class="text-end">
                                        {{ currency_format($detail->return_amount ?? 0, currency: business_currency()) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-between position-relative">
                <h2 class="word-amount">{{ amountInWords($total_return_amount) }}</h2>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start"></td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start"></td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start paid-by">{{ __('Payment Type') }} :
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
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Total Return Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($total_return_amount, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end total-amound">{{ __('Net Payable') }}</td>
                                <td class="text-end total-amound">:</td>
                                <td class="text-end total-amound">
                                    {{ currency_format($purchase->totalAmount, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Paid Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->paidAmount, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Due') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->dueAmount, currency: business_currency()) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- purchases --}}
            <div class="custom-invoice-table">
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
                    @php $subtotal = 0; @endphp
                    <tbody class="in-table-body-container">
                        @foreach ($purchase->details as $detail)
                            @php
                                $productTotal =
                                    ($detail->productPurchasePrice ?? 0) * ($detail->quantities ?? 0);
                                $subtotal += $productTotal;
                            @endphp
                            <tr class="in-table-body">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    {{ ($detail->product->productName ?? '') . (!empty($detail->stock?->batch_no) ? ' (' . $detail->stock?->batch_no . ')' : '') }}
                                </td>
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
            <div class="d-flex align-items-center justify-content-between position-relative">
                <h2 class="word-amount">{{ amountInWords($subtotal) }}</h2>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start"></td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start"></td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start paid-by">{{ __('Payment Type') }} :
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
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Subtotal') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($subtotal, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Vat') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->vat_amount, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Shipping Charge') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->shipping_charge, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
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
                            <tr class="in-table-row-bottom">
                                <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                <td class="text-end total-amound">:</td>
                                <td class="text-end total-amound">
                                    {{ currency_format($purchase->totalAmount, currency: business_currency()) }}
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Receive Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($purchase->paidAmount + $purchase->change_amount, currency: business_currency()) }}
                                </td>
                            </tr>
                            @if ($purchase->change_amount > 0)
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Change Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->change_amount, currency: business_currency()) }}
                                    </td>
                                </tr>
                            @else
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Due') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->dueAmount, currency: business_currency()) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif


        <div class="pdf-footer">
            <div class="in-signature-container d-flex align-items-center justify-content-between ">
                <div class="in-signature">
                    <hr class="in-hr">
                    <h4>{{ __('Customer Signature') }}</h4>
                </div>
                <div class="in-signature">
                    <hr class="in-hr">
                    <h4>{{ __('Authorized Signature') }}</h4>
                </div>
            </div>
            <div class="mt-2">
                @if (!empty(get_business_option('business-settings')['note']))
                <strong>{{ __('Note') }}</strong>: {{ get_business_option('business-settings')['note'] ?? '' }}
                @endif
            </div>
        </div>
    </div>
</div>

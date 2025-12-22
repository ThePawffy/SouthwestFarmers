<div class="invoice-container">
    <div class="invoice-content">
        {{-- Print Header --}}

        <div class="row py-2 d-print-none d-flex align-items-start justify-content-between border-bottom print-container">

            <div class="col-md-6 d-flex align-items-center p-2">
                <span class="Money-Receipt">{{ __('Money Receipt') }}</span>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-end ">
                <div class="d-flex gap-3 ">

                    <a class="print-btn-2 print-btn" onclick="window.print()"><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.62765 14.9998C4.85838 14.9998 3.97375 14.9998 3.34393 14.6222C2.93229 14.3753 2.60067 14.0224 2.38664 13.6033C2.05918 12.9621 2.1472 12.1143 2.32325 10.4186C2.47021 9.00309 2.54369 8.2953 2.90505 7.77551C3.14229 7.43425 3.46318 7.15454 3.83933 6.96111C4.41225 6.6665 5.15072 6.6665 6.62765 6.6665H14.371C15.848 6.6665 16.5864 6.6665 17.1594 6.96111C17.5355 7.15454 17.8564 7.43425 18.0937 7.77551C18.455 8.2953 18.5285 9.00309 18.6754 10.4186C18.8515 12.1143 18.9395 12.9621 18.612 13.6033C18.398 14.0224 18.0664 14.3753 17.6548 14.6222C17.0249 14.9998 16.1404 14.9998 14.371 14.9998" stroke="white" stroke-width="1.5"/>
                    <path d="M14.6673 6.6665V4.99984C14.6673 3.42849 14.6673 2.64281 14.1792 2.15466C13.691 1.6665 12.9053 1.6665 11.334 1.6665H9.66732C8.09597 1.6665 7.31029 1.6665 6.82214 2.15466C6.33398 2.64281 6.33398 3.42849 6.33398 4.99984V6.6665" stroke="white" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M12.1579 13.3335H8.8434C8.27234 13.3335 7.98679 13.3335 7.74384 13.4242C7.41991 13.5452 7.14254 13.7802 6.95582 14.0917C6.81578 14.3255 6.74653 14.6261 6.60802 15.2272C6.39159 16.1664 6.28339 16.636 6.35698 17.0126C6.45511 17.5147 6.76096 17.9397 7.18609 18.1647C7.50493 18.3335 7.95109 18.3335 8.8434 18.3335H12.1579C13.0502 18.3335 13.4964 18.3335 13.8152 18.1647C14.2403 17.9397 14.5462 17.5147 14.6443 17.0126C14.7179 16.636 14.6097 16.1664 14.3933 15.2272C14.2548 14.6261 14.1855 14.3255 14.0455 14.0917C13.8587 13.7802 13.5814 13.5452 13.2575 13.4242C13.0145 13.3335 12.729 13.3335 12.1579 13.3335Z" stroke="white" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M15.5 10H15.5075" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ __('Print') }}</a>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center gap-3 print-logo-container">
            <!-- Left Side: Logo and Content -->
            <div class="d-flex align-items-center in-logo-container gap-2 logo">
                <img class="invoice-logo" src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/icons/default.svg') ?? '' }}" alt="Logo">
                <h4>{{ $due_collect->business->companyName ?? 'Grocery Shop' }}</h4>
            </div>

            <!-- Right Side: Invoice -->
            <h3 class="right-invoice mb-0 align-self-center ">{{ __('MONEY RECEIPT') }}</h3>
        </div>
        <div class="d-flex align-items-start justify-content-between flex-wrap">
            <div>
                <table class="table">
                    <tbody>
                        <tr class="in-table-row">
                            <td class="text-start">{{ __('Bill To') }}</td>
                            <td class="text-start">: {{ $party->name ?? 'Cash' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start">{{ __('Mobile') }}</td>
                            <td class="text-start">: {{ $party->phone ?? '' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start">{{ __('Address') }}</td>
                            <td class="text-start">: {{ $party->address ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <table class="table">
                    <tbody>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Receipt') }}</td>
                            <td class="text-start ">: {{ $due_collect->invoiceNumber ?? '' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Date') }}</td>
                            <td class="text-start">: {{ formatted_date($due_collect->paymentDate ?? '') }}
                            </td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start ">{{ __('Collected By') }}</td>
                            <td class="text-start">: {{ $due_collect->business->companyName ?? '' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start">{{ $due_collect->business->vat_name ?? '' }}</td>
                            @if (!empty($due_collect->business->vat_name))
                                <td class="text-start"> : {{ $due_collect->business->vat_no ?? '' }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr class="in-table-header">
                        <th class="head-red text-start">{{ __('SL') }}</th>
                        <th class="head-red text-end">{{ __('Total Due') }}</th>
                        <th class="head-black text-end">{{ __('Payment Amount') }}</th>
                        <th class="head-black text-end">{{ __('Remaining Due') }}</th>
                    </tr>
                </thead>
                <tbody class="in-table-body-container">
                    <tr class="in-table-body">
                        <td class="text-start">1</td>
                        <td class="text-end">
                            {{ currency_format($due_collect->totalDue ?? 0, currency: business_currency()) }}</td>
                        <td class="text-end">
                            {{ currency_format($due_collect->payDueAmount ?? 0, currency: business_currency()) }}
                        </td>
                        <td class="text-end">
                            {{ currency_format($due_collect->dueAmountAfterPay ?? 0, currency: business_currency()) }}
                        </td>
                    </tr>
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
                            <td class="text-end">{{ __('Payable Amount') }}</td>
                            <td class="text-end">:</td>
                            <td class="text-end">
                                {{ currency_format($due_collect->totalDue ?? 0, currency: business_currency()) }}
                            </td>
                            </td>
                        </tr>

                        <tr class="in-table-row-bottom">
                            <td class="text-end">{{ __('Received Amount') }}</td>
                            <td class="text-end">:</td>
                            <td class="text-end">
                                {{ currency_format($due_collect->payDueAmount ?? 0, currency: business_currency()) }}
                            </td>
                            </td>
                        </tr>
                        <tr class="in-table-row-bottom">
                            <td class="text-end">{{ __('Due Amount') }}</td>
                            <td class="text-end">:</td>
                            <td class="text-end">
                                {{ currency_format($due_collect->dueAmountAfterPay ?? 0, currency: business_currency()) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pdf-footer">
            <div class="in-signature-container d-flex align-items-center justify-content-between">
                <div class="in-signature">
                    <hr class="in-hr">
                    <h4>{{ __('Customer Signature') }}</h4>
                </div>
                <div class="in-signature">
                    <hr class="in-hr">
                    <h4>{{ __('Authorized Signature') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

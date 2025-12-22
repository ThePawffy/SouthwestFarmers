<div class="invoice-container-sm">
    <div class="invoice-content invoice-content-size">

        <div class="invoice-logo mb-2">
            <img src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/icons/default.svg') ?? '' }}" alt="">
        </div>
        <div>
            <h4 class="company-name">{{ auth()->user()->name ?? '' }}</h4>
            <div class="company-info">
                <p>Address: {{ get_business_option('business-settings')['address'] ?? '' }}</p>
                <p>Mobile: {{ auth()->user()->phone ?? '' }}</p>
                <p>Email: {{ auth()->user()->email ?? '' }}</p>
                @if (!empty($due_collect->business->vat_name))
                   <p>{{ $due_collect->business->vat_name }} : {{ $due_collect->business->vat_no ?? '' }}</p>
                @endif
            </div>
        </div>
        <h3 class="invoice-title my-1">
            invoice
        </h3>

        <div class="invoice-info">
            <div class="">
                <p>Invoice : {{ $due_collect->invoiceNumber ?? '' }}</p>
                <p>Bill To: {{ $party->name ?? 'Cash' }}</p>
                <p>Mobile: {{ $party->phone ?? '' }}</p>
            </div>
            <div class="">
                <p class="text-end date">Date : {{ formatted_date($due_collect->paymentDate ?? '') }}</p>
                <p class="text-end time">Time: {{ formatted_time($due_collect->paymentDate ?? '') }}</p>
                <p class="text-end">Collected By: {{ $due_collect->business->companyName ?? '' }}</p>
            </div>
        </div>
        <table class="ph-invoice-table">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th>Total Due</th>
                    <th>Payment Amt</th>
                    <th class="text-end">Remaining Due</th>
                </tr>
            </thead>


            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>{{ currency_format($due_collect->totalDue ?? 0, currency: business_currency()) }}</td>
                    <td class="text-center">
                        {{ currency_format($due_collect->payDueAmount ?? 0, currency: business_currency()) }}</td>
                    <td class="text-end">
                        {{ currency_format($due_collect->dueAmountAfterPay ?? 0, currency: business_currency()) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="">
                        <div class="payment-type-container">
                            <h6 class="text-start">Payment Type:
                                {{ $due_collect->payment_type_id != null ? $due_collect->payment_type->name ?? '' : $due_collect->paymentType }}
                            </h6>
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="calculate-amount">

                            <div class="d-flex justify-content-between ">
                                <p>Payable Amount:</p>
                                <p>{{ currency_format($due_collect->totalDue ?? 0, currency: business_currency()) }}</p>
                            </div>

                            <div class="d-flex justify-content-between ">
                                <p>Received Amount:</p>
                                <p>{{ currency_format($due_collect->payDueAmount ?? 0, currency: business_currency()) }}
                                </p>
                            </div>

                            <div class="d-flex justify-content-between ">
                                <p>Due:</p>
                                <p>{{ currency_format($due_collect->dueAmountAfterPay ?? 0, currency: business_currency()) }}
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>

        </table>

        <div class="invoice-footer-sm mt-3">
            <h5>{{ get_business_option('business-settings')['gratitude_message'] ?? '' }}</h5>
            @if (!empty(get_business_option('business-settings')['note']))
            <p class="text-center note-pera">Note : {{ get_business_option('business-settings')['note'] ?? '' }}</p>
            @endif

            <div class="scanner">
                <img src="{{ asset(get_business_option('business-settings')['invoice_scanner_logo'] ?? 'assets/images/icons/scanner.svg') }}" alt="">
            </div>
            <h6>{{ get_option('general')['admin_footer_text'] ?? '' }} <a href="{{ get_option('general')['admin_footer_link'] ?? '#' }}" target="_blank">{{ get_option('general')['admin_footer_link_text'] ?? '' }}</h6>
        </div>
    </div>
</div>

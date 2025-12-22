<div class="invoice-container-sm">
    <div class="invoice-content invoice-content-size">

        <div class="invoice-logo mb-2">
            <img src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/icons/default.svg') ?? '' }}" alt="">
        </div>
        <div>
            <h4 class="company-name">{{ auth()->user()->name ?? '' }}</h4>
            <div class="company-info">
                <p> {{__('Address')}} : {{ get_business_option('business-settings')['address'] ?? '' }}</p>
                <p> {{__('Mobile')}} : {{ auth()->user()->phone ?? '' }}</p>
                <p> {{__('Email')}} : {{ auth()->user()->email ?? '' }}</p>
                @if (!empty($party->dueCollect->business->vat_name))
                  <p>{{ $party->dueCollect->business->vat_name }} : {{ $party->dueCollect->business->vat_no ?? '' }}</p>
                @endif
            </div>
        </div>
        <h3 class="invoice-title my-1">
             {{__('invoice')}}
        </h3>

        <div class="invoice-info">
            <div class="">
                <p> {{__('Invoice')}} : {{ $party->dueCollect->invoiceNumber ?? '' }}</p>
                <p> {{__('Bill To')}} : {{ $party->name ?? 'Cash' }}</p>
                <p> {{__('Mobile')}} : {{ $party->phone ?? '' }}</p>
            </div>
            <div class="">
                <p class="text-end date"> {{__('Date')}} : {{ formatted_date($party->dueCollect->paymentDate ?? '') }}</p>
                <p class="text-end time"> {{__('Time')}} : {{ formatted_time($party->dueCollect->paymentDate ?? '') }}</p>
                <p class="text-end"> {{__('Collected By')}} : {{ $party->dueCollect->business->companyName ?? '' }}</p>
            </div>
        </div>
        <table class="ph-invoice-table">
            <thead>
                <tr>
                    <th class="text-center"> {{__('SL')}} </th>
                    <th> {{__('Total Due')}} </th>
                    <th> {{__('Payment Amt')}} </th>
                    <th class="text-end"> {{__('Remaining Due')}} </th>
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
                            <h6 class="text-start"> {{__('Payment Type')}} :
                                {{ $due_collect->payment_type_id != null ? $due_collect->payment_type->name ?? '' : $due_collect->paymentType }}
                            </h6>
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="calculate-amount">

                            <div class="d-flex justify-content-between ">
                                <p> {{__('Payable Amount')}} :</p>
                                <p>{{ currency_format($due_collect->totalDue ?? 0, currency: business_currency()) }}
                                </p>
                            </div>

                            <div class="d-flex justify-content-between ">
                                <p> {{__('Received Amount')}} :</p>
                                <p>{{ currency_format($due_collect->payDueAmount ?? 0, currency: business_currency()) }}
                                </p>
                            </div>

                            <div class="d-flex justify-content-between ">
                                <p> {{__('Due')}} :</p>
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
            <p class="text-center note-pera"> {{__('Note')}} : {{ get_business_option('business-settings')['note'] ?? '' }}</p>
            @endif
            <div class="scanner">
                <img src="{{ asset(get_business_option('business-settings')['invoice_scanner_logo'] ?? 'assets/images/icons/scanner.svg') }}" alt="">
            </div>
            <h6>{{ get_option('general')['admin_footer_text'] ?? '' }} <a href="{{ get_option('general')['admin_footer_link'] ?? '#' }}" target="_blank">{{ get_option('general')['admin_footer_link_text'] ?? '' }}</h6>
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('assets/js/custom/onload-print.js') }}"></script>
@endpush

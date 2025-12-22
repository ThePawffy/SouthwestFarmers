@foreach($purchases as $purchase)
    <tr>
        <td class="w-60 checkbox table-data">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $purchase->id }}">
        </td>
        <td>{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ formatted_date($purchase->purchaseDate) }}</td>
        <td class="text-start table-data" title="{{ $purchase->meta['note'] ?? '' }}">{{ $purchase->invoiceNumber }}</td>
        <td class="text-start table-data">{{ $purchase->party->name }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->totalAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->discountAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->paidAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->dueAmount, currency: business_currency()) }}</td>
        <td class="table-data">
            @if($purchase->details->sum('quantities') == 0)
                <div class="return-badge">{{ __('Returned') }}</div>
            @elseif($purchase->dueAmount == 0)
                <div class="paid-badge">{{ __('Paid') }}</div>
            @elseif($purchase->dueAmount > 0 && $purchase->dueAmount < $purchase->totalAmount)
                <div class="partial-badge">{{ __('Partial Paid') }}</div>
            @else
                <div class="unpaid-badge">{{ __('Unpaid') }}</div>
            @endif
        </td>
        <td class="print-d-none table-data">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="{{ route('business.purchases.invoice', $purchase->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="" >
                            {{ __('Invoice') }}
                        </a>
                    </li>
                    @if($purchase->paidAmount > 0)
                    <li>
                        <a href="javascript:void(0);" class="purchase-payment-view" data-id="{{ $purchase->id }}">
                            <i class="fal fa-eye"></i>
                            {{__('View Payments')}}
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('business.purchase-returns.create', ['purchase_id' => $purchase->id]) }}">
                            <i class="fal fa-undo-alt"></i>
                            {{ __('Purchase Return') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.purchases.pdf', $purchase->id) }}">
                            <i class="fal fa-file-pdf"></i>
                            {{ __('Download') }}
                        </a>
                    </li>
                    @if(!in_array($purchase->id, $purchasesWithReturns))
                        <li>
                            <a href="{{ route('business.purchases.edit', $purchase->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('business.purchases.destroy', $purchase->id) }}" class="confirm-action"
                               data-method="DELETE">
                                <i class="fal fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </td>
    </tr>
    <input type="hidden" id="purchase-payment-view-url" value="{{ route('business.purchases.view-payments', ['id' => 'PURCHASE_ID']) }}">
@endforeach

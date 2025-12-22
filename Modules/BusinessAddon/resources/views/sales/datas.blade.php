@foreach ($sales as $sale)
    <tr>
        <td class="w-60 checkbox table-data">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $sale->id }}">
        </td>
        <td>{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ formatted_date($sale->saleDate) }}</td>
        <td class="text-start table-data" title="{{ $sale->meta['note'] ?? '' }}">{{ $sale->invoiceNumber }}</td>
        <td class="text-start table-data">{{ $sale->party->name ?? 'Cash' }}</td>
        <td class="text-start table-data">{{ currency_format($sale->totalAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($sale->discountAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($sale->paidAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($sale->dueAmount, currency: business_currency()) }}</td>
        <td class="table-data">
            @if($sale->details->sum('quantities') == 0)
                <div class="return-badge">{{ __('Returned') }}</div>
            @elseif($sale->dueAmount == 0)
                <div class="paid-badge">{{ __('Paid') }}</div>
            @elseif($sale->dueAmount > 0 && $sale->dueAmount < $sale->totalAmount)
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
                        <a target="_blank" href="{{ route('business.sales.invoice', $sale->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            {{ __('Invoice') }}
                        </a>
                    </li>
                    @if($sale->paidAmount > 0)
                    <li>
                        <a href="javascript:void(0);" class="sale-payment-view" data-id="{{ $sale->id }}">
                            <i class="fal fa-eye"></i>
                            {{__('View Payments')}}
                        </a>
                    </li>
                    @endif
                    @if($sale->details->sum('quantities') != 0)
                    <li>
                        <a href="{{ route('business.sale-returns.create', ['sale_id' => $sale->id]) }}">
                            <i class="fal fa-undo-alt"></i>
                            {{ __('Sales Return') }}
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('business.sales.pdf', $sale->id) }}">
                            <i class="fal fa-file-pdf"></i>
                            {{ __('Download') }}
                        </a>
                    </li>
                    @if(!in_array($sale->id, $salesWithReturns))
                        <li>
                            <a href="{{ route('business.sales.edit', $sale->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    <li>
                        <a href="{{ route('business.sales.destroy', $sale->id) }}" class="confirm-action"
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
    <input type="hidden" id="sale-payment-view-url" value="{{ route('business.sales.view-payments', ['id' => 'SALE_ID']) }}">
@endforeach

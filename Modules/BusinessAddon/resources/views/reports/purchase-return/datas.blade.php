@foreach($purchases as $purchase)

    @php
        $total_return_amount = $purchase->purchaseReturns->sum('total_return_amount');
    @endphp

    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
        <td class="table-data">
            <a href="{{ route('business.sales.invoice', $purchase->id) }}" target="_blank" class="text-primary">
                {{ $purchase->invoiceNumber }}
            </a>
        </td>
        <td class="table-data">{{ formatted_date($purchase->purchaseDate) }}</td>
        <td class="table-data">{{ $purchase->party->name ?? '' }}</td>
        <td class="table-data">{{ currency_format($purchase->totalAmount ?? 0, currency: business_currency()) }}</td>
        <td class="table-data">{{ currency_format($purchase->paidAmount ?? 0, currency: business_currency()) }}</td>
        <td class="table-data">{{ currency_format($total_return_amount ?? 0, currency: business_currency()) }}</td>
    </tr>
@endforeach

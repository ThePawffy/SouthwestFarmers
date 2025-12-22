@foreach($purchases as $purchase)
        @php
            $total_return_amount = $purchase->purchaseReturns->sum('total_return_amount');
        @endphp
    <tr>
        <td class="table-data">{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
        <td class="table-data">
            <a href="{{ route('business.purchases.invoice', $purchase->id) }}" target="_blank" class="text-primary">
                {{ $purchase->invoiceNumber }}
            </a>
        </td>
        <td class="table-data">{{ formatted_date($purchase->purchaseDate) }}</td>
        <td class="table-data">{{ $purchase->party->name ?? '' }}</td>
        <td class="table-data">{{ currency_format($purchase->totalAmount , currency: business_currency()) }}</td>
        <td class="table-data">{{ currency_format($purchase->paidAmount, currency: business_currency()) }}</td>
        <td class="table-data">{{ currency_format($purchase->paidAmount, currency: business_currency()) }}</td>
        <td class="table-data">{{ currency_format($total_return_amount ?? 0, currency: business_currency()) }}</td>
    </tr>
@endforeach

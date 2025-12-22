@foreach($purchases as $purchase)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ $purchase->invoiceNumber }}</td>
        <td class="text-start table-data">{{ $purchase->party?->name }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->totalAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->discountAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->paidAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->dueAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($purchase->vat_amount, currency: business_currency()) }}</td>
        <td class="text-start table-data">
            @if($purchase->paymentTypes && $purchase->paymentTypes->isNotEmpty())
                {{ $purchase->paymentTypes->pluck('name')->implode(', ') }}
            @else
                {{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}
            @endif
        </td>
        <td class="text-start table-data">{{ formatted_date($purchase->purchaseDate) }}</td>
    </tr>
@endforeach

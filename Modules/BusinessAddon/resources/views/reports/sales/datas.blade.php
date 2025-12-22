@foreach($sales as $sale)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ $sale->invoiceNumber }}</td>
        <td class="text-start table-data">{{ $sale->party?->name ?? 'Cash'}}</td>
        <td class="text-start table-data">{{ currency_format($sale->totalAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($sale->discountAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($sale->paidAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($sale->dueAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($sale->vat_amount, currency: business_currency()) }}</td>
        <td class="text-start table-data">
            @if($sale->paymentTypes && $sale->paymentTypes->isNotEmpty())
                {{ $sale->paymentTypes->pluck('name')->implode(', ') }}
            @else
                {{ $sale->payment_type_id != null ? $sale->payment_type->name ?? '' : $sale->paymentType }}
            @endif
        </td>
        <td class="text-start table-data">{{ formatted_date($sale->saleDate) }}</td>
    </tr>
@endforeach

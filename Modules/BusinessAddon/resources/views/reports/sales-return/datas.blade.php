@foreach($sales as $sale)

    @php
        $total_return_amount = $sale->saleReturns->sum('total_return_amount');
    @endphp

    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td>
        <td class="table-data">
            <a href="{{ route('business.sales.invoice', $sale->id) }}" target="_blank" class="text-primary">
                {{ $sale->invoiceNumber }}
            </a>
        </td>
        <td class="table-data">{{ formatted_date($sale->saleDate) }}</td>
        <td class="table-data">{{ $sale->party->name ?? 'Cash' }}</td>
        <td class="table-data">{{ currency_format($sale->totalAmount ?? 0, currency: business_currency()) }}</td>
        <td class="table-data">{{ currency_format($sale->paidAmount ?? 0, currency: business_currency()) }}</td>
        <td class="table-data">{{ currency_format($total_return_amount ?? 0, currency: business_currency()) }}</td>
    </tr>
@endforeach

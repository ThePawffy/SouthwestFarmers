@foreach($transactions as $transcation)
    <tr>
        <td class="table-data">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">
            @if ($transcation->party_id)
                <a href="{{ route('business.collect.dues.invoice', $transcation->party_id) }}" class="text-primary" target="_blank">
                    {{ $transcation->invoiceNumber }}
                </a>
            @else
                <a href="{{ route('business.collect.walk-dues.invoice', $transcation->invoiceNumber) }}" class="text-primary" target="_blank">
                    {{ $transcation->invoiceNumber }}
                </a>
            @endif
        </td>

        <td class="text-start table-data">{{ $transcation->party?->name ?? 'Cash'}}</td>
        <td class="text-start table-data">{{ currency_format($transcation->totalDue, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ currency_format($transcation->payDueAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ $transcation->payment_type_id != null ? $transcation->payment_type->name ?? '' : $transcation->paymentType }}</td>
        <td class="text-start table-data">{{ formatted_date($transcation->paymentDate) }}</td>
    </tr>
@endforeach

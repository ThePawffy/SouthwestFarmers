@foreach($loss_profits as $loss_profit)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($loss_profits->currentPage() - 1) * $loss_profits->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ $loss_profit->invoiceNumber }}</td>
        <td class="text-start table-data">{{ $loss_profit->party?->name ?? 'Cash'}}</td>
        <td class="text-start table-data">{{ currency_format($loss_profit->totalAmount, currency: business_currency()) }}</td>
        <td class="text-start table-data">
            @php
                $amount = abs($loss_profit->lossProfit);
            @endphp
            <span class="{{ $loss_profit->lossProfit < 0 ? 'text-danger' : 'text-success' }} px-2 py-1 rounded d-inline-block">
                {{ currency_format($amount, currency: business_currency()) }}
            </span>
        </td>

        <td class="text-start table-data">{{ formatted_date($loss_profit->saleDate) }}</td>
        <td class="text-start table-data">
            <span class="{{ $loss_profit->dueAmount == 0 ? 'text-success px-2 py-1 rounded' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'text-warning px-2 py-1 rounded' : 'text-danger px-2 py-1 rounded') }}">
                {{ $loss_profit->dueAmount == 0 ? 'Paid' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'Partial Paid' : 'Unpaid') }}
            </span>
        </td>
    </tr>
@endforeach



@foreach($expense_reports as $expense_report)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($expense_reports->currentPage() - 1) * $expense_reports->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ currency_format($expense_report->amount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ $expense_report->category->categoryName }}</td>
        <td class="text-start table-data">{{ $expense_report->expanseFor }}</td>
        <td class="text-start table-data">{{ $expense_report->payment_type_id != null ? $expense_report->payment_type->name ?? '' : $expense_report->paymentType }}</td>
        <td class="text-start table-data">{{ $expense_report->referenceNo }}</td>
        <td class="text-start table-data">{{ formatted_date($expense_report->expenseDate) }}</td>
    </tr>
@endforeach

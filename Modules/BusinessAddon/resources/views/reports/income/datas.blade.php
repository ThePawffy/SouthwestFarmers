@foreach($income_reports as $income_report)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($income_reports->currentPage() - 1) * $income_reports->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ currency_format($income_report->amount, currency: business_currency()) }}</td>
        <td class="text-start table-data">{{ $income_report->category->categoryName }}</td>
        <td class="text-start table-data">{{ $income_report->incomeFor }}</td>
        <td class="text-start table-data">{{ $income_report->payment_type_id != null ? $income_report->payment_type->name ?? '' : $income_report->paymentType }}</td>
        <td class="text-start table-data">{{ $income_report->referenceNo }}</td>
        <td class="text-start table-data">{{ formatted_date($income_report->incomeDate) }}</td>
    </tr>
@endforeach

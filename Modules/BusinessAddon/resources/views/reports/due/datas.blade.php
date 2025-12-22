@foreach($due_lists as $due_list)
    <tr class="table-data {{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td>{{ ($due_lists->currentPage() - 1) * $due_lists->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data ">{{ $due_list->name }}</td>
        <td class="text-start table-data ">{{ $due_list->email }}</td>
        <td class="text-start table-data ">{{ $due_list->phone }}</td>
        <td class="text-start table-data ">{{ $due_list->type }}</td>
        <td class="text-end table-data ">{{ currency_format($due_list->due, currency: business_currency()) }}</td>
    </tr>
@endforeach

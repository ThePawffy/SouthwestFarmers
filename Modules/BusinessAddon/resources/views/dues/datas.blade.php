@foreach($dues as $due)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($dues->currentPage() - 1) * $dues->perPage() + $loop->iteration }}</td>
        <td class="table-data">{{ $due->name }}</td>
        <td class="table-data">{{ $due->email }}</td>
        <td class="table-data">{{ $due->phone }}</td>
        <td class="table-data">{{ $due->type }}</td>
        <td class="text-danger table-data">{{ currency_format($due->due, currency: business_currency()) }}</td>
        <td class="print-d-none table-data">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('business.collect.dues', $due->id) }}">
                            <i class="fal fa-edit"></i>
                            {{ __('Collect Due') }}
                        </a>
                    </li>
                    @if($due->dueCollect)
                        <li>
                            <a href="{{ route('business.collect.dues.invoice', $due->id) }}" target="_blank">
                                <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="" >
                                {{ __('Invoice') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </td>
    </tr>
@endforeach

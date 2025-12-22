@foreach ($parties as $party)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
            <td class="w-60 checkbox table-data">
                <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $party->id }}">
            </td>
        <td class="table-data">{{ ($parties->currentPage() - 1) * $parties->perPage() + $loop->iteration }}</td>
        <td class="table-data">
            <img src="{{ asset($party->image ?? 'assets/img/icon/no-image.svg') }}" alt="Img" class="table-img">
        </td>
        <td class="table-data">{{ $party->name }}</td>
        <td class="table-data">{{ $party->email }}</td>
        <td class="table-data">{{ $party->type == 'Retailer' ? 'Customer': $party->type }}</td>
        <td class="table-data">{{ $party->phone }}</td>
        <td class="text-danger table-data">{{ currency_format($party->due, currency: business_currency()) }}</td>
        <td class="print-d-none table-data">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#parties-view" class="parties-view-btn" data-bs-toggle="modal"
                            data-name="{{ $party->name }}" data-email="{{ $party->email }}"
                            data-phone="{{ $party->phone }}" data-type="{{ $party->type }}"
                            data-due="{{ currency_format($party->due, currency: business_currency()) }}" data-address="{{ $party->address }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.parties.edit', [$party->id, 'type' => request('type')]) }}"><i class="fal fa-edit"></i>{{ __('Edit') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.parties.destroy', $party->id) }}" class="confirm-action"
                            data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach

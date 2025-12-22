@foreach ($currencies as $currency)
    <tr>
        <td class="table-data">{{ ($currencies->currentPage() - 1) * $currencies->perPage() + $loop->iteration }}</td>
        <td class="table-data">{{ $currency->name }}</td>
        <td class="table-data">{{ $currency->country_name }}</td>
        <td class="table-data">{{ $currency->code }}</td>
        <td class="table-data">{{ $currency->symbol }}</td>
        <td class="table-data">
            <div class="d-flex align-items-center justify-content-center">
                <div class="{{ ($user_currency && $currency->name == $user_currency->name) || (!$user_currency && $currency->is_default == 1) ? 'yes-badge' : 'no-badge'  }}">
                    {{ ($user_currency && $currency->name == $user_currency->name) || (!$user_currency && $currency->is_default == 1) ? 'Yes' : 'No' }}
                </div>
            </div>
        </td>
        <td class="print-d-none table-data">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                @if(!$user_currency || $user_currency->name != $currency->name)
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('business.currencies.default', ['id' => $currency->id]) }}">
                            <i class="fas fa-adjust"></i>
                            {{ __('Make Default') }}
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </td>
    </tr>
@endforeach

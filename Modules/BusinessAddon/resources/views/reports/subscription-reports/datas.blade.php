@foreach ($subscribers as $subscriber)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($subscribers->currentPage() - 1) * $subscribers->perPage() + $loop->iteration }}</td>
        <td class="table-data">{{ formatted_date($subscriber->created_at) }}</td>
        <td class="table-data">
             <div class="
            @php $subscription = $subscriber->plan->subscriptionName ?? null; @endphp

            @switch($subscription)
            @case('Premium')
                btn-premium
                @break
            @case('Free')
                btn-free
                @break
            @case('Standard')
                btn-standard
                @break
            @default
                btn-common
            @endswitch
            ">
                {{ $subscription ?? '' }}
            </div>
        </td>
        <td class="table-data">{{ formatted_date($subscriber->created_at) }}</td>
        <td class="table-data">{{ $subscriber->created_at ? formatted_date($subscriber->created_at->addDays($subscriber->duration)) : '' }}</td>
        <td class="table-data">{{ $subscriber->gateway->name ?? 'N/A' }}</td>
        <td class="table-data">
            <div class="badge bg-{{ $subscriber->payment_status == 'unpaid' ? 'danger' : 'primary' }}">
                {{ ucfirst($subscriber->payment_status) }}
            </div>
        </td>
        <td class="table-data">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="{{ route('business.subscription-reports.invoice', $subscriber->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            {{ __('Invoice') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach


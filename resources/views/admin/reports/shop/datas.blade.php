@foreach ($allshops as $business)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class='table-data'>{{ $loop->index + 1 }} <i class="{{ request('id') == $business->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td class='table-data'>{{ $business->companyName }}</td>
        <td class='table-data'>{{ $business->category->name ?? '' }}</td>
        <td class='table-data'>{{ $business->phoneNumber }}</td>
           <td class='table-data'>
            <div class="
            @php $subscription = $business->enrolled_plan->plan->subscriptionName ?? null; @endphp

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
        <td class='table-data'>{{ formatted_date($business->subscriptionDate) }}</td>
        <td class='table-data'>{{ formatted_date($business->will_expire) }}</td>
    </tr>
@endforeach

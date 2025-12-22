@foreach($cart_contents as $cart)
    @php
        $modules = product_setting()->modules ?? [];
    @endphp
    <tr data-row_id="{{ $cart->rowId }}" data-update_route="{{ route('business.carts.update', $cart->rowId) }}" data-destroy_route="{{ route('business.carts.destroy', $cart->rowId) }}">
        <td>{{ $loop->iteration }}</td>
        <td class="text-start">{{ $cart->name }}</td>
        @if (is_module_enabled($modules, 'show_product_batch_no'))
            <td>
                <input type="text" name="batch_no" class="batch_no sales-input text-center" value="{{ $cart->options->batch_no ?? '' }}">
            </td>
        @endif
        @if (is_module_enabled($modules, 'show_product_expire_date'))
            <td>
                @if (isset($modules['expire_date_type']) && ($modules['expire_date_type'] == 'dmy' || is_null($modules['expire_date_type'])))
                    <input type="date" name="expire_date" value="{{ date('Y-m-d', strtotime($cart->options->expire_date ?? '')) }}" class="form-control expire_date">
                @else
                    <input type="month" name="expire_date" value="{{ date('Y-m', strtotime($cart->options->expire_date ?? '')) }}" class="form-control expire_date">
                @endif
            </td>
        @endif
        <td><input class="text-center sales-input price" type="number" step="any" min="0" value="{{ $cart->price }}" placeholder="0"></td>
        <td class='text-start sales-purchase-td'>
            <div class="d-flex align-items-center justify-content-center gap-2">
                <button class="incre-decre minus-btn">
                    <i class="fas fa-minus icon"></i>
                </button>
                <input type="number" step="any" value="{{ $cart->qty }}" class="custom-number-input cart-qty" placeholder="{{ __('0') }}">
                <button class="incre-decre plus-btn">
                    <i class="fas fa-plus icon"></i>
                </button>
            </div>
        </td>
        <td class="text-center sales-input cart-subtotal">{{ currency_format($cart->subtotal, currency: business_currency()) }}</td>
        <td>
            <button class='x-btn remove-btn'>
                <img src="{{ asset('assets/images/icons/x.svg') }}" alt="">
            </button>
        </td>
    </tr>
@endforeach

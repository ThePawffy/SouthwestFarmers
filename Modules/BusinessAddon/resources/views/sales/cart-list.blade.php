@if(isset($cart_contents))
    @foreach($cart_contents as $cart)
        <tr data-row_id="{{ $cart->rowId }}" data-batch_no="{{ $cart->options->batch_no ?? '' }}" data-stock_id="{{ $cart->options->stock_id ?? '' }}" data-update_route="{{ route('business.carts.update', $cart->rowId) }}" data-destroy_route="{{ route('business.carts.destroy', $cart->rowId) }}">
            <td>{{ $loop->iteration }}</td>
            <td class="text-start">{{ $cart->name }}</td>
            <td>{{ $cart->options->batch_no ?? '' }}</td>
            <td>
                <input class="text-center sales-input cart-price " type="number" step="any" min="0" value="{{ $cart->price }}" placeholder="0">
            </td>
            <td class="large-td sales-purchase-td">
                <div class="d-flex gap-2 align-items-center" >
                    <button class="incre-decre minus-btn">
                        <i class="fas fa-minus icon"></i>
                    </button>
                    <input type="number" step="any" value="{{ $cart->qty }}" class="custom-number-input cart-qty" placeholder="{{ __('0') }}" >
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
@endif

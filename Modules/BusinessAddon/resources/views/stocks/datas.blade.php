@foreach ($products as $product)

    @php
        $total_stock = $product->stocks->sum('productStock');
        $firstStock = $product->stocks->first();
        $total_value = $product->stocks->sum(function ($stock) {
            return $stock->productPurchasePrice * $stock->productStock;
        });
    @endphp

    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="table-data">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">
            @php
                $batchStocks = $product->stocks->map(function ($batch) {
                    return [
                        'batch_no' => $batch->batch_no,
                        'expire_date' => $batch->expire_date ? formatted_date($batch->expire_date) : 'N/A',
                        'productStock' => $batch->productStock ?? 0,
                        'productSalePrice' => $batch->productSalePrice ?? 0,
                        'productDealerPrice' => $batch->productDealerPrice ?? 0,
                        'productPurchasePrice' => $batch->productPurchasePrice ?? 0,
                        'productWholeSalePrice' => $batch->productWholeSalePrice ?? 0,
                    ];
                });
            @endphp
            <a href="javascript:void(0);" class="stock-view-data text-primary" data-stocks='@json($batchStocks)'>
                {{ $product->productName }}
            </a>
        </td>
        <td class="text-start table-data">{{ $product->category?->categoryName }}</td>
        <td class="text-start table-data">{{ currency_format(optional($firstStock)->productPurchasePrice, currency: business_currency()) }}</td>
        <td class="{{ $total_stock <= $product->alert_qty ? 'text-danger' : 'text-success' }} text-start table-data">
            {{ $total_stock }}
        </td>
        <td class="text-center table-data">{{ currency_format(optional($firstStock)->productSalePrice, currency: business_currency()) }}</td>
        <td class="text-end table-data">{{ currency_format($total_value, currency : business_currency()) }}</td>
    </tr>
@endforeach
<tr>
    <td colspan="6" class="text-end table-data"><strong>{{ __('Total Stock Value') }}:</strong></td>
    <td class="text-end table-data"><strong>{{ currency_format($total_stock_value, currency : business_currency()) }}</strong></td>
</tr>

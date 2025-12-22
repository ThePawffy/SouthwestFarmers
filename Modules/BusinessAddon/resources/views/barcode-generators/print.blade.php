@extends('businessAddon::layouts.blank')

@section('title')
    {{ __('Invoice') }}
@endsection

@push('css')
    @if ($printer == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/label-38mm-25mm.css') }}">
    @elseif ($printer == 2)
        <link rel="stylesheet" href="{{ asset('assets/css/label-50mm-25mm.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/label-a4.css') }}">
    @endif
@endpush

@section('main_content')
    {{-- <div id="barcodePrintArea" class="barcode-container ">
        <div class="row g-2 ">
            @foreach ($generatedBarcodes ?? [] as $barcode)
                <div class="col-lg-3">
                    <div class="barcode-content">
                        @if ($barcode['show_business_name'])
                            <p style="font-size: {{ $barcode['business_name_size'] }}px;" class="product-name">
                                {{ $barcode['business_name'] }}
                            </p>
                        @endif
                        @if ($barcode['show_product_name'])
                            <p class="title" style="font-size: {{ $barcode['product_name_size'] }}px;">
                                {{ $barcode['product_name'] }}
                            </p>
                        @endif
                        @if ($barcode['show_product_price'])
                            <p class="price" style="font-size: {{ $barcode['product_price_size'] }}px;">
                               {{__('Price')}} : <span>{{ currency_format($barcode['product_price'], currency:business_currency()) }}</span>
                            </p>
                        @endif
                        @if ($barcode['show_pack_date'])
                            <p class="date" style="font-size: {{ $barcode['pack_date_size'] }}px;">
                               {{__('Packing Date')}} : {{ $barcode['packing_date'] }}
                            </p>
                        @endif
                        <img src="data:image/png;base64,{{ base64_encode($barcode['barcode_svg']) }}" alt="Barcode Image">
                        @if ($barcode['show_product_code'])
                            <p class="number" style="font-size: {{ $barcode['product_code_size'] }}px;">
                                {{ $barcode['product_code'] }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
       <div id="barcodePrintArea">
        <div class="barcode-print-container">
            @foreach ($generatedBarcodes ?? [] as $barcode)
                <div class="print-label pt-1">
                    @if ($barcode['show_business_name'])
                        <p style="font-size: {{ $barcode['business_name_size'] }}px;" class="product-name">
                            {{ $barcode['business_name'] }}
                        </p>
                    @endif
                    @if ($barcode['show_product_name'])
                        <p style="font-size: {{ $barcode['product_name_size'] }}px;" class="product-name">
                            {{ $barcode['product_name'] }}
                        </p>
                    @endif
                    @if ($barcode['show_product_price'])
                        <p style="font-size: {{ $barcode['product_price_size'] }}px;" class="product-price">
                            Price: <span>{{ currency_format($barcode['product_price'], currency:business_currency()) }}</span>
                        </p>
                    @endif
                    @if ($barcode['show_pack_date'] && ($barcode['packing_date'] ?? false))
                        <span style="font-size: {{ $barcode['pack_date_size'] }}px;">
                            Packing Date: {{ $barcode['packing_date'] }}
                        </span>
                    @endif
                    <img class="barcode" src="data:image/png;base64,{{ base64_encode($barcode['barcode_svg']) }}" alt="Barcode Image">
                    @if ($barcode['show_product_code'])
                        <span style="font-size: {{ $barcode['product_code_size'] }}px;" class="pt-1">
                            {{ $barcode['product_code'] }}
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset("assets/js/custom/onload-print.js") }}"></script>
@endpush

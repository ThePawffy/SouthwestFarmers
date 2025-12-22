@extends('businessAddon::layouts.blank')

@section('title')
    {{ __('Invoice') }}
@endsection

@section('main_content')
    @if (invoice_setting() == '3_inch_80mm')
        @include('businessAddon::walk-dues.invoices.3_inch_80mm')
    @else
        @include('businessAddon::walk-dues.invoices.a4')
    @endif
@endsection

@push('js')
    <script src="{{ asset('assets/js/custom/onloadPrint.js') }}"></script>
@endpush

@push('js')
<script src="{{ asset('assets/js/custom/onload-print.js') }}"></script>
@endpush

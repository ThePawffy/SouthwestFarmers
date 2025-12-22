@extends('businessAddon::layouts.blank')

@section('title')
    {{ __('Invoice') }}
@endsection

@section('main_content')
    @if (invoice_setting() == '3_inch_80mm')
        @include('businessAddon::dues.invoices.3_inch_80mm')
    @else
        @include('businessAddon::dues.invoices.a4')
    @endif
@endsection

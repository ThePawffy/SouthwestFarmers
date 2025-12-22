@extends('businessAddon::layouts.blank')

@section('title')
    {{ __('Invoice') }}
@endsection

@section('main_content')
    @if (invoice_setting() == '3_inch_80mm')
        @include('businessAddon::sales.invoices.3_inch_80mm')
    @else
        @include('businessAddon::sales.invoices.a4')
    @endif
@endsection

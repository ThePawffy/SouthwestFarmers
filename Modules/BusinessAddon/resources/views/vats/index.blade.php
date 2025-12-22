@extends('businessAddon::layouts.master')

@section('title')
    {{ __('Vats') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card vat-tax-card shadow-sm vatlist-body">
                <div class="table-header p-16">
                    <h4>{{ __('Vat List') }}</h4>
                        <div>
                            <a href="#vat-add-modal" class="theme-btn print-btn text-light active custom-a" data-bs-toggle="modal"> <i class="fas fa-plus-circle me-1"></i> {{ __('Add New Vat') }}</a>
                        </div>
                </div>
                      <div class="table-top-form p-16-0">
                        <form action="{{ route('business.vats.filter') }}" method="post" class="filter-form"
                            table="#vat-data">
                            @csrf
                            <div class="table-top-left d-flex gap-3 margin-l-16">
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="per_page" class="form-control">
                                        <option value="10">{{ __('Show- 10') }}</option>
                                        <option value="2">{{ __('Show- 25') }}</option>
                                        <option value="50">{{ __('Show- 50') }}</option>
                                        <option value="100">{{ __('Show- 100') }}</option>
                                    </select>
                                    <span></span>
                                </div>
                                <div class="table-search position-relative">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="{{ __('Search...') }}">
                                    <span class="position-absolute">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                            </svg>

                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="card-body p-0 mx-3">
                    <div class="delete-item delete-show d-none">
                        <div class="delete-item-show m-0 mt-3 mb-3">
                            <p class="fw-bold"><span class="selected-count"></span> {{ __('items show') }}</p>
                            <button data-bs-toggle="modal" class="trigger-modal" data-bs-target="#multi-delete-modal" data-url="{{ route('business.vats.deleteAll') }}">{{ __('Delete') }}</button>
                        </div>
                    </div>

                </div>
                <div class="responsive-table vat-tax-table vatlist-body mt-0">
                    <table class="table bg-striped" id="datatable">
                        <thead>
                            <tr>
                                <th class="w-60 striped-th">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" class="select-all-delete multi-delete">
                                    </div>
                                </th>
                                <th class="w-60 striped-th">{{ __('SL') }}.</th>
                                <th class="striped-th">{{ __('Name') }}</th>
                                <th class="striped-th">{{ __('Tax Rate') }}</th>
                                <th class="striped-th">{{ __('Status') }}</th>
                                <th class="text-center striped-th">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="vat-data">
                            @include('businessAddon::vats.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $vats->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>

        <div class="mt-3">
            @include('businessAddon::vat-groups.index')
        </div>
    </div>
@endsection


@push('modal')
    @include('businessAddon::component.delete-modal')
    @include('businessAddon::vats.create')
    @include('businessAddon::vats.edit')
@endpush


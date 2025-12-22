@extends('landing::layouts.master')

@section('title')
    {{ __('Features List') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <div class="table-header p-16">
                    <h4>{{ __('Features List') }}</h4>
                    <a href="{{ route('admin.features.create') }}" class="theme-btn print-btn text-light">
                        <i class="far fa-plus" aria-hidden="true"></i>
                        {{ __('Create New') }}
                    </a>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="table-top-form p-16-0">
                    <form action="{{ route('admin.features.filter') }}" method="post" class="filter-form"
                    table="#features-data">
                        @csrf
                        <div class="table-top-left d-flex gap-3 margin-l-16 ">
                            <div class="gpt-up-down-arrow position-relative">
                                <select name="per_page" class="form-control">
                                    <option value="10">{{ __('Show- 10') }}</option>
                                    <option value="25">{{ __('Show- 25') }}</option>
                                    <option value="50">{{ __('Show- 50') }}</option>
                                    <option value="100">{{ __('Show- 100') }}</option>
                                </select>
                                <span></span>
                            </div>

                            <div class="table-search position-relative">
                                <input class="form-control searchInput" type="text" name="search"
                                    placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                                <span class="position-absolute">
                                    <img src="{{ asset('assets/images/search.svg') }}" alt="">
                                </span>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>

                <div class="responsive-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class='striped-th'>
                                    <div class="d-flex align-items-center gap-1">
                                        <label class="table-custom-checkbox">
                                            <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox">
                                            <span class="table-custom-checkmark custom-checkmark"></span>
                                        </label>
                                        <i class="fal fa-trash-alt delete-selected"></i>
                                    </div>
                                </th>
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="features-data">
                            @include('landing::admin.features.datas')
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination">
                        <li class="page-item">{{ $features->links('pagination::bootstrap-5') }}</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush

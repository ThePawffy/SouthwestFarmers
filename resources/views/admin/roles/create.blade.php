@extends('layouts.master')

@section('title')
    {{__('Roles')}}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">


            <div class="table-header p-16">
                <h4>{{__('Add New Role')}}</h4>
                <small class="text-warning">{{ __('Set role permissions') }}</small>
            </div>
            <div class="row justify-content-center mt-2 roles-permissions p-16">
                <div class="col-md-12">
                    <form action="{{ route('admin.roles.store') }}" method="post" class="row ajaxform_instant_reload">
                        @csrf

                        <div class="col-12 form-group role-input-label">
                            <label for="name" class="required">{{ __("Role Name") }}</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="{{ __("Enter role name") }}" required>
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mt-3 mb-3 permission-title">Select Permission</h4>
                                <div class="custom-control custom-checkbox d-flex align-items-center">
                                    <div class="custom-control d-flex align-items-center justify-content-center gap-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input select-all-delete multi-delete" id="selectAll">
                                        <label class="custom-control-label fw-bold" for="selectAll">{{ __('Select All') }}</label>
                                    </div>
                                </div>
                            </div>
                           <div class="responsive-table m-0">
                                <table class="table bg-striped" id="datatable">
                                    <thead>
                                        <tr>
                                            <th class="striped-th">SL.</th>
                                            <th class=" striped-th text-start">
                                                {{ __("Setup role permissions") }}
                                            </th>
                                            <th class="striped-th text-start">
                                                Permission
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groups as $key => $group)
                                            <tr>
                                                <td>{{$loop->iteration }}</td>
                                                <td class="text-start striped-th">{{ $key }}</td>
                                                <td class="striped-th">
                                                    <div class="d-flex gap-3">
                                                        @foreach($group as $permission)
                                                            <div class="custom-control d-flex align-items-center gap-3 custom-checkbox mr-3 me-lg-5">
                                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="delete-checkbox-item  multi-delete" id="id_{{ $permission->id }}">
                                                                <label class="custom-control-label " for="id_{{ $permission->id }}">
                                                                    {{ ucfirst(str($permission->name)->explode('-')->last()) }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 text-center mt-2 d-flex align-items-center justify-content-center gap-3">
                                <button type="reset" class="btn btn-sm role-reset-btn">
                                    <i class="fas fa-undo-alt"></i> {{ __("Reset") }}
                                </button>
                                <button type="submit" class="btn btn-sm btn-warning btn-custom-warning fw-bold me-2 submit-btn"><i class="fas fa-save"></i> {{ __("Save") }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


                </div>
            </div>
        </div>
    </div>
@endsection


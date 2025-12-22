<div class="modal fade common-validation-modal" id="tutorial-create-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Create Tutorial') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="{{ route('admin.tutorials.store') }}" method="post" class="ajaxform_instant_reload">
                        @csrf

                        <div class="row">
                            <div class="mt-3 mb-2 position-relative col-lg-12">
                                <label>{{ __('Thumbnail') }}</label>
                                <div class="upload-img-v2">
                                    <div class="d-flex upload-v4 align-items-center gap-3">
                                        <input type="file" name="thumbnail" class="form-control" />
                                        <div class="img-wrp">
                                            <img src="{{ asset('assets/images/icons/no-img.svg') }}"
                                                alt="Thumbnail Preview" class="preview rounded-1"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-2">
                                <label class="required">{{ __('Title') }}</label>
                                <input type="text" name="title" required class="form-control"
                                    placeholder="{{ __('Enter Title') }}">
                            </div>

                            <div class="col-lg-12 mt-1">
                                <label class="required">{{ __('Url') }}</label>
                                <textarea name="url" class="form-control" placeholder="{{ __('Enter Url') }}"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade common-validation-modal" id="faq-edit-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Edit Faq') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="" method="post" class="ajaxform_instant_reload faqUpdateForm">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label class="required">{{ __('Question') }}</label>
                                <input type="text" name="question" id="question" required class="form-control" placeholder="{{ __('Enter Question') }}">
                            </div>

                            <div class="col-lg-12 mt-1">
                                <label class="required">{{__('Answer')}}</label>
                                <textarea name="answer" id="answer" class="form-control" placeholder="{{ __('Enter Answer') }}"></textarea>
                            </div>
                         </div>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <a href="{{ route('admin.faqs.index') }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

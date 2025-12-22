@extends('landing::layouts.web.master')

@section('title')
    {{ __('Contact us') }}
@endsection


@section('main_content')
    <div class="banner-bg  blog-header p-4">
        <div class="container">
            <p class="mb-0 fw-bolder custom-clr-dark">
                Home <span class="font-monospace">></span> Contact Us
            </p>
        </div>
    </div>

    <section class="contact-section">
        <div class="container">
            <div data-aos='fade-up' class="section-title text-center">
                <h2 class="langing-section-title pb-3">
                    {{ Str::words($page_data['headings']['contact_us_title'] ?? '', 10, '...') }}
                </h2>
                <p class="section-description pt-0">
                    {{ Str::words($page_data['headings']['contact_us_description'] ?? '', 20, '...') }}

                </p>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-3 align-self-center">
                    <div class="contact-image">
                        <img src="{{ asset($page_data['contact_us_icon'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="image" class="w-100 object-fit-cover rounded-2" />
                    </div>
                </div>
                <div class="col-lg-6 mb-3 align-self-center">
                    <form action="{{ route('contact.store') }}" method="post" class="ajaxform_instant_reload">
                        @csrf
                        <div class="row contact">
                            <div class="col-md-12 mb-2">
                                <label for="full-name" class="col-form-label fw-medium">Full Name <span
                                        class="text-orange">*</span></label>
                                <input type="text" name="name" class="form-control" id="full-name"
                                    placeholder="Enter full name" />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="phone-number" class="col-form-label fw-medium">Phone Number <span
                                        class="text-orange">*</span></label>
                                <input type="number" name="phone" class="form-control" id="phone-number"
                                    placeholder="Enter phone number" />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="email" class="col-form-label fw-medium">Email <span
                                        class="text-orange">*</span></label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Enter email address " />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="company-name" class="col-form-label fw-medium">Company
                                    <small class="text-body-secondary">(Optional)</small></label>
                                <input type="text" name="company_name" class="form-control"
                                    placeholder="Enter company name" />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="message" class="col-form-label fw-medium">Message</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Enter your message"></textarea>
                            </div>
                            <div class="py-1 mt-3">
                                <button type="submit" class="custom-btn custom-message-btn submit-btn">
                                    {{ Str::words($page_data['headings']['contact_us_btn_text'] ?? '', 3, '...') }} <svg
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 1.25C6.072 1.25 1.25 6.072 1.25 12C1.25 17.928 6.072 22.75 12 22.75C17.928 22.75 22.75 17.928 22.75 12C22.75 6.072 17.928 1.25 12 1.25ZM12 21.25C6.899 21.25 2.75 17.101 2.75 12C2.75 6.899 6.899 2.75 12 2.75C17.101 2.75 21.25 6.899 21.25 12C21.25 17.101 17.101 21.25 12 21.25ZM16.6919 12.2871C16.6539 12.3791 16.599 12.462 16.53 12.531L13.53 15.531C13.384 15.677 13.192 15.751 13 15.751C12.808 15.751 12.616 15.678 12.47 15.531C12.177 15.238 12.177 14.763 12.47 14.47L14.1899 12.75H8C7.586 12.75 7.25 12.414 7.25 12C7.25 11.586 7.586 11.25 8 11.25H14.189L12.469 9.53003C12.176 9.23703 12.176 8.76199 12.469 8.46899C12.762 8.17599 13.237 8.17599 13.53 8.46899L16.53 11.469C16.599 11.538 16.6539 11.6209 16.6919 11.7129C16.7679 11.8969 16.7679 12.1031 16.6919 12.2871Z"
                                            fill="white" />
                                    </svg>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

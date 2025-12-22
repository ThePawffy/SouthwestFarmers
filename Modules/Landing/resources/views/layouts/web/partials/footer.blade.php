{{-- Footer Code Start --}}
<footer class="footer-section py-3">
    <div class="container">
        <div class="row mt-5 justify-content-between align-items-center ">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('home') }}">
                    <img class="footer-logo"
                        src="{{ asset($page_data['footer_image'] ?? 'assets/images/icons/img-upload.png') }}"
                        alt="footer-logo" class="w-50" />
                </a>
                <p class="mt-4">
                    {{ Str::words($page_data['headings']['footer_short_title'] ?? '', 15, '...') }}

                </p>

                <div class="banner-scan footer-scan">
                    <img src="{{ asset($page_data['footer_scanner_image'] ?? 'assets/images/icons/img-upload.png') }}"
                        alt="" class="w-20" />
                    <p>
                        {{ Str::words($page_data['headings']['footer_scanner_title'] ?? '', 10, '...') }}

                    </p>
                </div>


                <div class="pt-2 download-option">
                    <a href="{{ $page_data['headings']['footer_apple_app_link'] ?? '' }}" target="_blank">
                        <img src="{{ asset($page_data['footer_apple_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="image" />
                    </a>
                    <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}" target="_blank">
                        <img src="{{ asset($page_data['footer_google_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="image" />
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="footer-features">
                    <div class="">
                        <h6 class="mb-4 mt-4 mt-md-3 text-white footer-title ">
                            Our App Features</h6>
                        <div class="d-flex align-items-center gap-5 footer-menu ">
                            <ul>

                                <li>
                                    <a href="{{ $page_data['headings']['right_footer_link_one'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['right_footer_one'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['right_footer_link_two'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['right_footer_two'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['right_footer_link_three'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['right_footer_three'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['right_footer_link_four'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['right_footer_four'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['right_footer_link_five'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['right_footer_five'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['right_footer_link_six'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['right_footer_six'] ?? '' }}</a>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <a href="{{ $page_data['headings']['middle_footer_link_one'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['middle_footer_one'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['middle_footer_link_two'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['middle_footer_two'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['middle_footer_link_three'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['middle_footer_three'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['middle_footer_link_four'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['middle_footer_four'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['middle_footer_link_five'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['middle_footer_five'] ?? '' }}</a>
                                </li>
                                <li>
                                    <a href="{{ $page_data['headings']['middle_footer_link_six'] ?? '' }}"
                                        target="_blank">{{ $page_data['headings']['middle_footer_six'] ?? '' }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="col-md-6 col-lg-3"></div> --}}
            <div class="col-md-6 col-lg-3 quick-footer footer-menu">
                <h6 class="mb-4  text-white footer-title">Quick Links</h6>
                <ul>
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_one'] ?? '') }}"
                            target="_blank">{{ $page_data['headings']['left_footer_one'] ?? '' }}</a>
                    </li>
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_two'] ?? '') }}"
                            target="_blank">{{ $page_data['headings']['left_footer_two'] ?? '' }}</a>
                    </li>
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_three'] ?? '') }}"
                            target="_blank">{{ $page_data['headings']['left_footer_three'] ?? '' }}</a>
                    </li>
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_four'] ?? '') }}"
                            target="_blank">{{ $page_data['headings']['left_footer_four'] ?? '' }}</a>
                    </li>

                </ul>
                <div class="social-icon">
                    @foreach ($page_data['headings']['footer_socials_links'] ?? [] as $key => $footer_socials_links)
                        <a href="{{ $footer_socials_links ?? '' }}">
                            <img class="footer-social-icon"
                                src="{{ asset($page_data['footer_socials_icons'][$key] ?? 'assets/img/demo-img.png') }}"
                                alt="icon" />
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <hr class="custom-clr-white" />
        <div class="text-center">
            <p class="text-white mb-0">{{ $general->value['copy_right'] ?? '' }}</p>
        </div>
    </div>
</footer>

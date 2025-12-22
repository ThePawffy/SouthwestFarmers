@extends('landing::layouts.web.master')

@section('title')
    {{ __(env('APP_NAME')) }}
@endsection

@section('main_content')
    <section class="home-banner-section">
        <div class="container">
            <div class="row align-items-center ">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <h1 data-aos="fade-right">
                            {{ str_word_count($page_data['headings']['slider_title'] ?? '') > 6
                                ? implode(' ', array_slice(explode(' ', $page_data['headings']['slider_title'] ?? ''), 0, 6)) . '...'
                                : $page_data['headings']['slider_title'] ?? '' }}

                            <span
                                data-typer-targets='{"targets": [
                                @foreach ($page_data['headings']['silder_shop_text'] ?? [] as $key => $shop)
                                    "{{ str_word_count($shop) > 5 ? implode(' ', array_slice(explode(' ', $shop), 0, 5)) . '...' : $shop }}"@if (!$loop->last),@endif @endforeach
                            ]}'>
                            </span>
                        </h1>

                        <p data-aos="fade-right" data-aos-delay="300" >
                            {{ Str::words($page_data['headings']['slider_description'] ?? '', 20, '...') }}
                        </p>
                        <div data-aos="fade-right" data-aos-delay="600" class="demo-btn-group mb-3">
                            <a class="custom-btn custom-primary-btn" href="#plans">
                                {{ Str::words($page_data['headings']['slider_btn1'] ?? '', 4, '...') }}
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.5 1.25C6.572 1.25 1.75 6.072 1.75 12C1.75 17.928 6.572 22.75 12.5 22.75C18.428 22.75 23.25 17.928 23.25 12C23.25 6.072 18.428 1.25 12.5 1.25ZM12.5 21.25C7.399 21.25 3.25 17.101 3.25 12C3.25 6.899 7.399 2.75 12.5 2.75C17.601 2.75 21.75 6.899 21.75 12C21.75 17.101 17.601 21.25 12.5 21.25ZM17.1919 12.2871C17.1539 12.3791 17.099 12.462 17.03 12.531L14.03 15.531C13.884 15.677 13.692 15.751 13.5 15.751C13.308 15.751 13.116 15.678 12.97 15.531C12.677 15.238 12.677 14.763 12.97 14.47L14.6899 12.75H8.5C8.086 12.75 7.75 12.414 7.75 12C7.75 11.586 8.086 11.25 8.5 11.25H14.689L12.969 9.53003C12.676 9.23703 12.676 8.76199 12.969 8.46899C13.262 8.17599 13.737 8.17599 14.03 8.46899L17.03 11.469C17.099 11.538 17.1539 11.6209 17.1919 11.7129C17.2679 11.8969 17.2679 12.1031 17.1919 12.2871Z"
                                        fill="white" />
                                </svg>
                            </a>

                            {{-- <a href="" class="mt-1 video-button d-flex align-items-center gap-2"
                                data-bs-toggle="modal" data-bs-target="#watch-video-modal">
                                <span class="play-button d-flex align-items-center justify-content-center">
                                </span>
                                <span
                                    class="watch-text ms-2">{{ Str::words($page_data['headings']['slider_btn2'] ?? '', 3, '...') }}
                                </span>
                            </a> --}}
                            <a href="#" class="d-flex align-items-center justify-content-center"
                                data-bs-toggle="modal" data-bs-target="#watch-video-modal">
                                <div id="play-video" class="video-play-button ">
                                    <p></p>
                                </div>
                                <span
                                    class="watch-text ">{{ Str::words($page_data['headings']['slider_btn2'] ?? '', 3, '...') }}
                                </span>
                            </a>
                            {{-- <div class="position-relative">
                                <span class="heartbeat"></span>
                                <span class="heartbeat"></span>
                                <span class="dot"></span>
                            </div> --}}

                        </div>

                        <div data-aos="fade-right" data-aos-delay="900" class="banner-scan">
                            <img class="scan-img"
                                src="{{ asset($page_data['scanner_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                alt="" />
                            <p class="scan-text">
                                {{ Str::words($page_data['headings']['slider_scanner_text'] ?? '', 9, '...') }}
                            </p>
                        </div>

                        <div data-aos="fade-right" data-aos-delay="1200"  class="d-flex align-items-center flex-wrap gap-2 mt-3 download-option">
                            <div class="">
                                <a href="{{ $page_data['headings']['apple_app_image'] ?? '' }}" target="_blank">
                                    <img src="{{ asset($page_data['apple_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                        alt="image" />
                                </a>
                                <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}"
                                    target="_blank"></a>
                            </div>

                            <div>
                                <a href="{{ $page_data['headings']['google_play_image'] ?? '' }}" target="_blank">
                                    <img src="{{ asset($page_data['google_play_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                        alt="image" />
                                </a>
                                <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}"
                                    target="_blank"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 position-relative">
                    <div data-aos="fade-left" class="banner-img  text-center">
                        <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="banner-img" class="w-75 move-image" />

                    </div>
                    <img data-aos="fade-left" class="element1 move-image" src="{{ 'assets/images/icons/elements1.svg' }}" alt=""
                        srcset="">
                    <img data-aos="fade-left" class="element2 move-image" src="{{ 'assets/images/icons/elements2.svg' }}" alt=""
                        srcset="">
                </div>
            </div>
            {{-- hero start code start --}}

            <div class="stat-container">
                <div class="stat-content p-3">
                    @foreach ($page_data['headings']['content_type_short_texts'] ?? [] as $key => $content_type_short_texts)
                        <div data-aos="fade-up" data-aos-delay="{{ $key * 300 }}" class="d-flex align-items-center gap-2 single-item">
                            <img src="{{ asset($page_data['content_type_icons'][$key] ?? 'assets/img/demo-img.png') }}"
                                id="image" class="">
                            <div class="">
                                @if (strpos($content_type_short_texts, '/') !== false)
                                    @php
                                        $numbers = explode('/', $content_type_short_texts); // Split "24/7" into ["24", "7"]
                                    @endphp
                                    <h2>
                                        <span class="counter" data-target="{{ $numbers[0] }}">0</span> /
                                        <span class="counter" data-target="{{ $numbers[1] }}">0</span>
                                    </h2>
                                @elseif (strpos($content_type_short_texts, '+') !== false)
                                    @php
                                        $number = preg_replace('/[^0-9.]/', '', $content_type_short_texts); // Extract the number
                                    @endphp
                                    <h2>
                                        <span class="counter" data-target="{{ $number }}">0</span>+
                                    </h2>
                                @else
                                    <h2 class="counter"
                                        data-target="{{ preg_replace('/[^0-9.]/', '', $content_type_short_texts) }}">0</h2>
                                @endif
                                <p>{{ Str::words($page_data['headings']['content_type_titles'][$key] ?? '', 3, '...') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- hero start code end --}}
        </div>
    </section>

    <div class="modal modal-custom-design" id="watch-video-modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe width="100%" height="400px" src="{{ $page_data['headings']['slider_btn2_link'] ?? '' }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Feature Code Start --}}

    @include('landing::web.components.feature')

    {{-- Interface Code Start --}}

    <section class="slick-slider-section section-gradient-bg">
        <div class="container">
            <div data-aos="fade-up" class="section-title text-center ">
                <p class="langing-section-subtitle ">
                    {{ Str::words($page_data['headings']['interface_short_text'] ?? '', 5, '...') }}
                </p>
                <h2 class="langing-section-title ">
                    {{ Str::words($page_data['headings']['interface_title'] ?? '', 15, '...') }}
                </h2>
                <p class="max-w-600 mx-auto section-description ">
                    {{ Str::words($page_data['headings']['interface_description'] ?? '', 20, '...') }}

                </p>
            </div>
            <div class="row app-slide">
                @foreach ($interfaces as $interface)
                    <div class="image d-flex align-items-center justify-content-center p-2">
                        <img src="{{ asset($interface->image) }}" alt="phone" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Pricing-Plan-section demo Code Start --}}
    @include('landing::web.components.plan')

    {{-- Watch demo Code Start --}}
    <section class="watch-demo-section watch-demo-two section-gradient-bg">
        <div class="container watch-video-container">

            <div data-aos="fade-right" class="video-wrapper position-relative">
                <img src="{{ asset($page_data['watch_image'] ?? 'assets/images/icons/img-upload.png') }}"
                    alt="watch" />
                {{-- <a class="play-btn" data-bs-toggle="modal" data-bs-target="#play-video-modal"></a> --}}
                <a class="watch-video play-btn" data-bs-toggle="modal" data-bs-target="#play-video-modal">
                    <p></p>
                </a>
            </div>
            <div class="watch-video-content">
                <p data-aos="fade-left" class="langing-section-subtitle ">
                    {{ Str::words($page_data['headings']['watch_title'] ?? '', 5, '...') }}
                </p>

                <h3 data-aos="fade-left" data-aos-delay="300" class="langing-section-title watch-video-title">
                    {{ Str::words($page_data['headings']['watch_long_title'] ?? '', 15, '...') }}
                </h3>

                <p data-aos="fade-left" data-aos-delay="600" class="section-description">
                    {{ Str::words($page_data['headings']['watch_description'] ?? '', 20, '...') }}

                </p>
                <div data-aos="fade-left" data-aos-delay="900" class="mt-3">
                    <a class="download-btn"
                        href="{{ $page_data['headings']['download_watch_btn_link'] ?? '' }}">{{ Str::words($page_data['headings']['download_watch_btn_text'] ?? '', 4, '...') }}

                        <svg width="20" height="20" viewBox="0 0 24 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.4776 9.51106C17.485 9.51102 17.4925 9.51101 17.5 9.51101C19.9853 9.51101 22 11.5294 22 14.0193C22 16.3398 20.25 18.2508 18 18.5M17.4776 9.51106C17.4924 9.34606 17.5 9.17896 17.5 9.01009C17.5 5.96695 15.0376 3.5 12 3.5C9.12324 3.5 6.76233 5.71267 6.52042 8.53192M17.4776 9.51106C17.3753 10.6476 16.9286 11.6846 16.2428 12.5165M6.52042 8.53192C3.98398 8.77373 2 10.9139 2 13.5183C2 15.9417 3.71776 17.9632 6 18.4273M6.52042 8.53192C6.67826 8.51687 6.83823 8.50917 7 8.50917C8.12582 8.50917 9.16474 8.88194 10.0005 9.51101"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12 21.5V13.5M12 21.5C11.2998 21.5 9.99153 19.5057 9.5 19M12 21.5C12.7002 21.5 14.0085 19.5057 14.5 19"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="modal modal-custom-design" id="play-video-modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe width="100%" height="400px" src="{{ $page_data['headings']['watch_btn_link'] ?? '' }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- User-panel-section demo Code Start --}}
    <section class="payment-method-container">
        <div class="container">
            <div class="">
                <div data-aos="fade-up" class="section-title text-center">
                    <p class="payment-subtitle">
                        {{ Str::words($page_data['headings']['payment_short_title'] ?? '', 5, '...') }}
                    </p>
                    <h4 class="payment-title">
                        {{ Str::words($page_data['headings']['payment_title'] ?? '', 15, '...') }}

                    </h4>
                </div>
                <div class="payment-img">
                    <img src="{{ asset($page_data['payment_image'] ?? 'assets/images/icons/img-upload.png') }}"
                        alt="">
                </div>
            </div>
        </div>
    </section>


    <section class="container">
        <div class="row align-items-center justify-content-center">

            <div class="col-lg-6 invoice-left-content">
                <h3 data-aos="fade-right" class="langing-section-title pb-4">
                    {{ Str::words($page_data['headings']['printer_title'] ?? '', 15, '...') }}
                </h3>
                <p data-aos="fade-right" data-aos-delay="300" class="section-description pt-0">
                    {{ Str::words($page_data['headings']['printer_desc'] ?? '', 40, '...') }}
                </p>
            </div>

            <div class="col-lg-6">
                <div data-aos="fade-left" class="banner-img invoice-img text-center">
                    <img src="{{ asset($page_data['printer_image'] ?? 'assets/images/icons/img-upload.png') }}"
                        alt="banner-img" class="" />
                </div>
            </div>
        </div>
    </section>


    {{-- Testimonial Section Start --}}
    <section class="customer-section section-gradient-bg">
        <div class="container mb-4">
            <div data-aos="fade-up" class="section-title text-center">
                <p class="section-description pt-0 langing-section-subtitle pb-0">{{ Str::words($page_data['headings']['testimonial_short_title'] ?? '', 15, '...') }}</p>
                <h2 class="langing-section-title">
                    {{ Str::words($page_data['headings']['testimonial_title'] ?? '', 15, '...') }}
                </h2>
            </div>

            <div class="customer-slider-section">
                <div class="row ">
                    @foreach ($testimonials as $testimonial)
                        <div class="customer-card ">
                            <img src="{{ asset($testimonial->client_image) }}" alt="" />
                            <p>
                                {{ Str::words($testimonial->text ?? '', 20, '...') }}
                            </p>
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <h5 class="m-0"> {{ Str::limit($testimonial->client_name ?? '', 20, '') }}</h5>
                                <small> {{ Str::limit($testimonial->work_at ?? '', 30, '') }}</small>
                                <p class="customer-star">
                                    @for ($i = 0; $i < $testimonial->star; $i++)
                                        ★
                                    @endfor
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    {{-- Blogs Section Code Start --}}

    <section class="blogs-section">
        <div class="container">
            <div data-aos="fade-up" class="section-title  d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <h2 class="langing-section-title blog-section-title">
                    {{ Str::words($page_data['headings']['blog_title'] ?? '', 15, '...') }}
                </h2>
                <a href="{{ url($page_data['headings']['blog_view_all_btn_link'] ?? '') }}"
                    class="custom-btn custom-outline-btn bg-white">
                    {{ Str::words($page_data['headings']['blog_view_all_btn_text'] ?? '', 3, '...') }}
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 1.25C6.072 1.25 1.25 6.072 1.25 12C1.25 17.928 6.072 22.75 12 22.75C17.928 22.75 22.75 17.928 22.75 12C22.75 6.072 17.928 1.25 12 1.25ZM12 21.25C6.899 21.25 2.75 17.101 2.75 12C2.75 6.899 6.899 2.75 12 2.75C17.101 2.75 21.25 6.899 21.25 12C21.25 17.101 17.101 21.25 12 21.25ZM16.6919 12.2871C16.6539 12.3791 16.599 12.462 16.53 12.531L13.53 15.531C13.384 15.677 13.192 15.751 13 15.751C12.808 15.751 12.616 15.678 12.47 15.531C12.177 15.238 12.177 14.763 12.47 14.47L14.1899 12.75H8C7.586 12.75 7.25 12.414 7.25 12C7.25 11.586 7.586 11.25 8 11.25H14.189L12.469 9.53003C12.176 9.23703 12.176 8.76199 12.469 8.46899C12.762 8.17599 13.237 8.17599 13.53 8.46899L16.53 11.469C16.599 11.538 16.6539 11.6209 16.6919 11.7129C16.7679 11.8969 16.7679 12.1031 16.6919 12.2871Z"
                            fill="#019934" />
                    </svg>

                </a>
            </div>
        </div>
    @include('landing::web.components.blog')
    </section>
    @include('landing::web.components.signup')
@endsection

@extends('landing::layouts.web.master')

@section('title')
    {{ __(env('APP_NAME')) }}
@endsection

@section('main_content')
    <section class="home-banner-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <h1 data-aos="fade-right" class="hero-main-title">
                            {{ str_word_count($page_data['headings']['slider_title'] ?? '') > 6
                                ? implode(' ', array_slice(explode(' ', $page_data['headings']['slider_title'] ?? ''), 0, 6)) . '...'
                                : $page_data['headings']['slider_title'] ?? 'Welcome to Southwest Farmer Market' }}

                            <span class="typing-text"
                                data-typer-targets='{"targets": [
                                @foreach ($page_data['headings']['silder_shop_text'] ?? ['Fresh Produce', 'Quality Products', 'Budget Friendly'] as $key => $shop)
                                    "{{ str_word_count($shop) > 5 ? implode(' ', array_slice(explode(' ', $shop), 0, 5)) . '...' : $shop }}"@if (!$loop->last),@endif 
                                @endforeach
                            ]}'>
                            </span>
                        </h1>

                        <p data-aos="fade-right" data-aos-delay="300" class="hero-description">
                            Welcome to the #1 African Grocery Chain Store in the States! We are pleased to offer our customers the convenience of both delivery and pickup options. Our delivery service is fast, reliable, and available for customers throughout the United States. If you prefer to pick up your order, we have convenient pickup locations available for you.
                        </p>
 <div class="get-btn-container">
                    <a
                        href="{{ $headerBtnLink && Route::has($headerBtnLink) ? route($headerBtnLink) : route('login') }}"
                        class="get-app-btn"
                    >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.48131 12.9012C4.30234 13.6032 1.21114 15.0366 3.09389 16.8304C4.01359 17.7065 5.03791 18.3332 6.32573 18.3332H13.6743C14.9621 18.3332 15.9864 17.7065 16.9061 16.8304C18.7888 15.0366 15.6977 13.6032 14.5187 12.9012C11.754 11.2549 8.24599 11.2549 5.48131 12.9012Z"
                                fill="white"></path>
                            <path
                                d="M13.75 5.4165C13.75 7.48757 12.0711 9.1665 10 9.1665C7.92893 9.1665 6.25 7.48757 6.25 5.4165C6.25 3.34544 7.92893 1.6665 10 1.6665C12.0711 1.6665 13.75 3.34544 13.75 5.4165Z"
                                fill="white"></path>
                        </svg>

                        {{ $headerBtnText ? Str::words($headerBtnText, 4, '...') : __('Login') }}
                    </a>
                </div>
                        <!-- <div data-aos="fade-right" data-aos-delay="600" class="cta-buttons-wrapper mt-4">
                            <a class="custom-btn custom-secondary-btn" href="#plans">
                                Explore Our Products
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.5 1.25C6.572 1.25 1.75 6.072 1.75 12C1.75 17.928 6.572 22.75 12.5 22.75C18.428 22.75 23.25 17.928 23.25 12C23.25 6.072 18.428 1.25 12.5 1.25ZM12.5 21.25C7.399 21.25 3.25 17.101 3.25 12C3.25 6.899 7.399 2.75 12.5 2.75C17.601 2.75 21.75 6.899 21.75 12C21.75 17.101 17.601 21.25 12.5 21.25ZM17.1919 12.2871C17.1539 12.3791 17.099 12.462 17.03 12.531L14.03 15.531C13.884 15.677 13.692 15.751 13.5 15.751C13.308 15.751 13.116 15.678 12.97 15.531C12.677 15.238 12.677 14.763 12.97 14.47L14.6899 12.75H8.5C8.086 12.75 7.75 12.414 7.75 12C7.75 11.586 8.086 11.25 8.5 11.25H14.689L12.969 9.53003C12.676 9.23703 12.676 8.76199 12.969 8.46899C13.262 8.17599 13.737 8.17599 14.03 8.46899L17.03 11.469C17.099 11.538 17.1539 11.6209 17.1919 11.7129C17.2679 11.8969 17.2679 12.1031 17.1919 12.2871Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div> -->
                    </div>
                </div>
                
                <div class="col-lg-6 position-relative">
                    <div data-aos="fade-left" class="banner-img text-center">
                        <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="Southwest Farmer Market" class="hero-image move-image" />
                    </div>
                    <img data-aos="fade-left" class="element1 move-image floating-element" 
                        src="{{ asset('assets/images/icons/elements1.svg') }}" alt="" />
                    <img data-aos="fade-left" class="element2 move-image floating-element" 
                        src="{{ asset('assets/images/icons/elements2.svg') }}" alt="" />
                </div>
            </div>

            {{-- Stats Section --}}
            <!-- <div class="stat-container" data-aos="fade-up" data-aos-delay="900">
                <div class="stat-content">
                    @foreach ($page_data['headings']['content_type_short_texts'] ?? ['1000+', '500+', '50+', '24/7'] as $key => $content_type_short_texts)
                        <div data-aos="fade-up" data-aos-delay="{{ ($key + 3) * 200 }}" class="stat-item">
                            <div class="stat-icon-wrapper">
                                <img src="{{ asset($page_data['content_type_icons'][$key] ?? 'assets/img/demo-img.png') }}"
                                    alt="icon" class="stat-icon">
                            </div>
                            <div class="stat-details">
                                @if (strpos($content_type_short_texts, '/') !== false)
                                    @php
                                        $numbers = explode('/', $content_type_short_texts);
                                    @endphp
                                    <h2 class="stat-number">
                                        <span class="counter" data-target="{{ $numbers[0] }}">0</span> /
                                        <span class="counter" data-target="{{ $numbers[1] }}">0</span>
                                    </h2>
                                @elseif (strpos($content_type_short_texts, '+') !== false)
                                    @php
                                        $number = preg_replace('/[^0-9.]/', '', $content_type_short_texts);
                                    @endphp
                                    <h2 class="stat-number">
                                        <span class="counter" data-target="{{ $number }}">0</span>+
                                    </h2>
                                @else
                                    <h2 class="stat-number counter"
                                        data-target="{{ preg_replace('/[^0-9.]/', '', $content_type_short_texts) }}">0</h2>
                                @endif
                                <p class="stat-label">
                                    {{ Str::words($page_data['headings']['content_type_titles'][$key] ?? 'Label', 3, '...') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> -->
        </div>
    </section>

    <style>
        .home-banner-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            position: relative;
            overflow: hidden;
        }

        .home-banner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(76, 175, 80, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 50%, rgba(33, 150, 243, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-main-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
        }

        .typing-text {
            display: block;
            color: #4CAF50;
            font-size: 3rem;
            margin-top: 0.5rem;
        }

        .hero-description {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .cta-buttons-wrapper {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .custom-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 16px 32px;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-secondary-btn {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
        }

        .custom-secondary-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        }

        .hero-image {
            max-width: 85%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .floating-element {
            position: absolute;
            animation: float 6s ease-in-out infinite;
        }

        .element1 {
            top: 10%;
            right: 10%;
            width: 80px;
        }

        .element2 {
            bottom: 15%;
            right: 5%;
            width: 60px;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .move-image {
            animation: moveImage 8s ease-in-out infinite;
        }

        @keyframes moveImage {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-15px) scale(1.02);
            }
        }

        .stat-container {
            margin-top: 60px;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .stat-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon-wrapper {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            border-radius: 50%;
            padding: 12px;
        }

        .stat-icon {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #666;
            margin: 0.5rem 0 0 0;
            font-weight: 500;
        }

        @media (max-width: 992px) {
            .hero-main-title {
                font-size: 2.5rem;
            }

            .typing-text {
                font-size: 2rem;
            }

            .stat-content {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .home-banner-section {
                padding: 60px 0;
            }

            .hero-main-title {
                font-size: 2rem;
            }

            .typing-text {
                font-size: 1.5rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .stat-container {
                padding: 20px;
            }

            .stat-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
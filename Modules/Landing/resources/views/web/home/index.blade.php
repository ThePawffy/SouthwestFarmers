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

                        <div data-aos="fade-right" data-aos-delay="600" class="cta-buttons-wrapper mt-4">
                            <a class="custom-btn custom-primary-btn" href="/login">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 17L15 12L10 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Login
                            </a>
                        </div>
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
        </div>
    </section>

    <style>
        .home-banner-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
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

        .custom-primary-btn {
            background: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
        }

        .custom-primary-btn:hover {
            background: #4CAF50;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
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

        @media (max-width: 992px) {
            .hero-main-title {
                font-size: 2.5rem;
            }

            .typing-text {
                font-size: 2rem;
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

            .cta-buttons-wrapper {
                flex-direction: column;
            }

            .custom-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

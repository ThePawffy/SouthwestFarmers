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
                        <h1 data-aos="fade-right" data-aos-duration="1000" class="hero-main-title">
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

                        <p data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000" class="hero-description">
                            Welcome to the #1 African Grocery Chain Store in the States! We are pleased to offer our customers the convenience of both delivery and pickup options. Our delivery service is fast, reliable, and available for customers throughout the United States. If you prefer to pick up your order, we have convenient pickup locations available for you.
                        </p>

                        <div data-aos="fade-right" data-aos-delay="600" data-aos-duration="1000" class="cta-buttons-wrapper mt-4">
                            <a class="custom-btn custom-primary-btn" href="/login">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 17L15 12L10 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Login
                                <span class="btn-shine"></span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 position-relative">
                    <div data-aos="fade-left" data-aos-duration="1000" class="banner-img text-center">
                        <div class="image-wrapper">
                            <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                alt="Southwest Farmer Market" class="hero-image" />
                            <div class="image-glow"></div>
                        </div>
                    </div>
                    <img data-aos="fade-left" data-aos-delay="200" class="element1 floating-element" 
                        src="{{ asset('assets/images/icons/elements1.svg') }}" alt="" />
                    <img data-aos="fade-left" data-aos-delay="400" class="element2 floating-element" 
                        src="{{ asset('assets/images/icons/elements2.svg') }}" alt="" />
                </div>
            </div>
        </div>

        <!-- Animated Background Elements -->
        <div class="background-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
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
            animation: backgroundPulse 15s ease-in-out infinite;
        }

        @keyframes backgroundPulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        /* Animated Background Shapes */
        .background-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.15), rgba(76, 175, 80, 0.05));
            animation: floatShape 20s ease-in-out infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: 20%;
            right: -50px;
            animation-delay: 5s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 50%;
            animation-delay: 10s;
        }

        @keyframes floatShape {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translate(50px, -50px) scale(1.1);
                opacity: 0.5;
            }
            50% {
                transform: translate(0, -100px) scale(1);
                opacity: 0.3;
            }
            75% {
                transform: translate(-50px, -50px) scale(0.9);
                opacity: 0.4;
            }
        }

        .banner-content {
            position: relative;
            z-index: 1;
        }

        .hero-main-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            animation: titleSlideIn 1s ease-out;
        }

        @keyframes titleSlideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .typing-text {
            display: block;
            color: #4CAF50;
            font-size: 3rem;
            margin-top: 0.5rem;
            position: relative;
            text-shadow: 2px 2px 4px rgba(76, 175, 80, 0.2);
        }

        .typing-text::after {
            content: '|';
            animation: blink 1s step-end infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .hero-description {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 2rem;
            max-width: 600px;
            animation: fadeInUp 1s ease-out 0.3s backwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cta-buttons-wrapper {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.6s backwards;
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
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .custom-btn svg {
            transition: transform 0.3s ease;
        }

        .custom-btn:hover svg {
            transform: translateX(5px);
        }

        /* Button Shine Effect */
        .btn-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .custom-btn:hover .btn-shine {
            left: 100%;
        }

        .custom-primary-btn {
            background: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
        }

        .custom-primary-btn:hover {
            background: #4CAF50;
            color: white;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 30px rgba(76, 175, 80, 0.4);
        }

        .custom-primary-btn:active {
            transform: translateY(-2px) scale(1.02);
        }

        /* Image Wrapper with Glow Effect */
        .image-wrapper {
            position: relative;
            display: inline-block;
            animation: imageAppear 1.2s ease-out;
        }

        @keyframes imageAppear {
            from {
                opacity: 0;
                transform: scale(0.8) rotateY(-20deg);
            }
            to {
                opacity: 1;
                transform: scale(1) rotateY(0deg);
            }
        }

        .hero-image {
            max-width: 85%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 2;
            animation: floatImage 6s ease-in-out infinite;
            transition: transform 0.3s ease;
        }

        .hero-image:hover {
            transform: scale(1.05) rotateZ(2deg);
        }

        @keyframes floatImage {
            0%, 100% {
                transform: translateY(0) rotateZ(0deg);
            }
            25% {
                transform: translateY(-15px) rotateZ(1deg);
            }
            50% {
                transform: translateY(-20px) rotateZ(0deg);
            }
            75% {
                transform: translateY(-15px) rotateZ(-1deg);
            }
        }

        .image-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 90%;
            height: 90%;
            background: radial-gradient(circle, rgba(76, 175, 80, 0.3), transparent 70%);
            transform: translate(-50%, -50%);
            border-radius: 20px;
            z-index: 1;
            animation: glowPulse 3s ease-in-out infinite;
        }

        @keyframes glowPulse {
            0%, 100% {
                opacity: 0.5;
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                opacity: 0.8;
                transform: translate(-50%, -50%) scale(1.1);
            }
        }

        .floating-element {
            position: absolute;
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .floating-element:hover {
            animation-play-state: paused;
            transform: scale(1.2) rotateZ(15deg);
        }

        .element1 {
            top: 10%;
            right: 10%;
            width: 80px;
            animation-delay: 0s;
        }

        .element2 {
            bottom: 15%;
            right: 5%;
            width: 60px;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotateZ(0deg);
            }
            25% {
                transform: translateY(-20px) rotateZ(5deg);
            }
            50% {
                transform: translateY(-30px) rotateZ(0deg);
            }
            75% {
                transform: translateY(-20px) rotateZ(-5deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-main-title {
                font-size: 2.5rem;
            }

            .typing-text {
                font-size: 2rem;
            }

            .shape {
                opacity: 0.5;
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

            .element1, .element2 {
                width: 50px;
            }

            .shape {
                display: none;
            }
        }

        /* Smooth Scroll Performance */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endsection
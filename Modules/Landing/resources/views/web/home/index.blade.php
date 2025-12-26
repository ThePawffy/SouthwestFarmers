@extends('landing::layouts.web.master')

@section('title')
    {{ __(env('APP_NAME')) }}
@endsection

@section('main_content')
    <section class="home-banner-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner-content glass-card" data-aos="fade-right">
                        <h1 class="hero-main-title">
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
                            <a class="custom-btn custom-primary-btn glass-btn" href="/login">
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
                    <div data-aos="fade-left" class="banner-img text-center glass-image-wrapper">
                        <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="Southwest Farmer Market" class="hero-image move-image" />
                    </div>
                    <div class="floating-element element1 glass-orb" data-aos="fade-left"></div>
                    <div class="floating-element element2 glass-orb" data-aos="fade-left" data-aos-delay="200"></div>
                    <div class="floating-element element3 glass-orb" data-aos="fade-left" data-aos-delay="400"></div>
                </div>
            </div>
        </div>

        <!-- Animated Background Elements -->
        <div class="bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </section>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .home-banner-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Shapes */
        .bg-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float-shape 20s infinite ease-in-out;
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.8) 0%, transparent 70%);
            top: -10%;
            left: -10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(240, 147, 251, 0.8) 0%, transparent 70%);
            bottom: -10%;
            right: -10%;
            animation-delay: 7s;
        }

        .shape-3 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(118, 75, 162, 0.8) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 14s;
        }

        @keyframes float-shape {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(50px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-30px, 30px) scale(0.9);
            }
        }

        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 50px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            position: relative;
            z-index: 1;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 30px;
            padding: 2px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.1));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .hero-main-title {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.2;
            color: #ffffff;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 20px rgba(0, 0, 0, 0.3);
        }

        .typing-text {
            display: block;
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 3rem;
            margin-top: 0.5rem;
            font-weight: 900;
            animation: gradient-shift 3s ease infinite;
        }

        @keyframes gradient-shift {
            0%, 100% {
                filter: hue-rotate(0deg);
            }
            50% {
                filter: hue-rotate(20deg);
            }
        }

        .hero-description {
            font-size: 1.125rem;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
            text-shadow: 1px 1px 10px rgba(0, 0, 0, 0.2);
        }

        .cta-buttons-wrapper {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Glassmorphism Button */
        .glass-btn {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 18px 40px;
            font-size: 1.125rem;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            position: relative;
            overflow: hidden;
        }

        .glass-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .glass-btn:hover::before {
            left: 100%;
        }

        .glass-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px 0 rgba(31, 38, 135, 0.5);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .glass-btn svg {
            transition: transform 0.3s ease;
        }

        .glass-btn:hover svg {
            transform: translateX(5px);
        }

        /* Glass Image Wrapper */
        .glass-image-wrapper {
            position: relative;
            z-index: 1;
        }

        .hero-image {
            max-width: 90%;
            height: auto;
            border-radius: 30px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .hero-image:hover {
            transform: scale(1.02);
        }

        /* Glass Orbs */
        .glass-orb {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .element1 {
            top: 10%;
            right: 15%;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        }

        .element2 {
            bottom: 20%;
            right: 5%;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            animation-delay: 1s;
        }

        .element3 {
            top: 50%;
            right: 25%;
            width: 60px;
            height: 60px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            animation-delay: 2s;
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-30px);
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
                transform: translateY(-20px) scale(1.03);
            }
        }

        @media (max-width: 992px) {
            .hero-main-title {
                font-size: 2.5rem;
            }

            .typing-text {
                font-size: 2rem;
            }

            .glass-card {
                padding: 40px 30px;
            }
        }

        @media (max-width: 768px) {
            .home-banner-section {
                min-height: auto;
                padding: 60px 0;
            }

            .glass-card {
                padding: 30px 20px;
                margin-bottom: 30px;
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

            .glass-btn {
                width: 100%;
                justify-content: center;
            }

            .glass-orb {
                display: none;
            }

            .shape {
                width: 250px !important;
                height: 250px !important;
            }
        }
    </style>
@endsection
{{-- Enhanced Footer Section --}}
<footer class="footer-section">
    <div class="footer-wave-bg">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path fill="#ffffff" fill-opacity="0.1" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        </svg>
    </div>
    
    <div class="container">
        <div class="row mt-5 footer-main-content">
            {{-- Company Info Section --}}
            <div class="col-md-6 col-lg-3 footer-brand-section" data-aos="fade-up">
                <a href="{{ route('home') }}" class="footer-logo-link">
                    <img class="footer-logo"
                        src="{{ asset($page_data['footer_image'] ?? 'assets/images/icons/img-upload.png') }}"
                        alt="footer-logo" />
                </a>
                <p class="footer-description">
                    {{ Str::words($page_data['headings']['footer_short_title'] ?? 'Your trusted partner for quality products and services', 15, '...') }}
                </p>

                <div class="footer-scan-section">
                    <div class="scan-qr-wrapper">
                        <img src="{{ asset($page_data['footer_scanner_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="QR Code" class="qr-code" />
                    </div>
                    <p class="scan-text">
                        {{ Str::words($page_data['headings']['footer_scanner_title'] ?? 'Scan to download', 10, '...') }}
                    </p>
                </div>

                <div class="app-download-section">
                    <a href="{{ $page_data['headings']['footer_apple_app_link'] ?? '#' }}" target="_blank" class="app-store-btn">
                        <img src="{{ asset($page_data['footer_apple_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="Download on App Store" />
                    </a>
                    <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '#' }}" target="_blank" class="app-store-btn">
                        <img src="{{ asset($page_data['footer_google_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="Get it on Google Play" />
                    </a>
                </div>
            </div>

            {{-- Features Section --}}
            <div class="col-md-6 col-lg-6 footer-links-section" data-aos="fade-up" data-aos-delay="200">
                <div class="footer-features-wrapper">
                    <h6 class="footer-title">
                        <span class="title-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        Our App Features
                    </h6>
                    <div class="footer-links-grid">
                        <ul class="footer-menu">
                            <li>
                                <a href="{{ $page_data['headings']['right_footer_link_one'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['right_footer_one'] ?? 'Feature One' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['right_footer_link_two'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['right_footer_two'] ?? 'Feature Two' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['right_footer_link_three'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['right_footer_three'] ?? 'Feature Three' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['right_footer_link_four'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['right_footer_four'] ?? 'Feature Four' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['right_footer_link_five'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['right_footer_five'] ?? 'Feature Five' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['right_footer_link_six'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['right_footer_six'] ?? 'Feature Six' }}
                                </a>
                            </li>
                        </ul>
                        <ul class="footer-menu">
                            <li>
                                <a href="{{ $page_data['headings']['middle_footer_link_one'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['middle_footer_one'] ?? 'Service One' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['middle_footer_link_two'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['middle_footer_two'] ?? 'Service Two' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['middle_footer_link_three'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['middle_footer_three'] ?? 'Service Three' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['middle_footer_link_four'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['middle_footer_four'] ?? 'Service Four' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['middle_footer_link_five'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['middle_footer_five'] ?? 'Service Five' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $page_data['headings']['middle_footer_link_six'] ?? '#' }}" target="_blank">
                                    <span class="link-arrow">→</span>
                                    {{ $page_data['headings']['middle_footer_six'] ?? 'Service Six' }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Quick Links Section --}}
            <div class="col-md-6 col-lg-3 footer-quick-links" data-aos="fade-up" data-aos-delay="400">
                <h6 class="footer-title">
                    <span class="title-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Quick Links
                </h6>
                <ul class="footer-menu">
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_one'] ?? '#') }}" target="_blank">
                            <span class="link-arrow">→</span>
                            {{ $page_data['headings']['left_footer_one'] ?? 'About Us' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_two'] ?? '#') }}" target="_blank">
                            <span class="link-arrow">→</span>
                            {{ $page_data['headings']['left_footer_two'] ?? 'Contact' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_three'] ?? '#') }}" target="_blank">
                            <span class="link-arrow">→</span>
                            {{ $page_data['headings']['left_footer_three'] ?? 'Privacy Policy' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ url($page_data['headings']['left_footer_link_four'] ?? '#') }}" target="_blank">
                            <span class="link-arrow">→</span>
                            {{ $page_data['headings']['left_footer_four'] ?? 'Terms of Service' }}
                        </a>
                    </li>
                </ul>

                <div class="social-section">
                    <h6 class="social-title">Connect With Us</h6>
                    <div class="social-icons-wrapper">
                        @foreach ($page_data['headings']['footer_socials_links'] ?? [] as $key => $footer_socials_links)
                            <a href="{{ $footer_socials_links ?? '#' }}" class="social-icon-link" target="_blank">
                                <img class="social-icon"
                                    src="{{ asset($page_data['footer_socials_icons'][$key] ?? 'assets/img/demo-img.png') }}"
                                    alt="social icon" />
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="footer-bottom" data-aos="fade-up" data-aos-delay="600">
            <hr class="footer-divider" />
            <div class="footer-copyright">
                <p class="copyright-text">
                    {{ $general->value['copy_right'] ?? '© 2024 All rights reserved' }}
                </p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <span class="separator">•</span>
                    <a href="#">Terms of Service</a>
                    <span class="separator">•</span>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Back to Top Button --}}
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
</footer>

<style>
.footer-section {
    background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%);
    padding: 80px 0 30px;
    position: relative;
    overflow: hidden;
}

.footer-wave-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 120px;
}

.footer-wave-bg svg {
    width: 100%;
    height: 100%;
}

.footer-main-content {
    position: relative;
    z-index: 2;
}

/* Brand Section */
.footer-brand-section {
    padding-right: 30px;
}

.footer-logo-link {
    display: inline-block;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}

.footer-logo-link:hover {
    transform: scale(1.05);
}

.footer-logo {
    max-width: 180px;
    height: auto;
    filter: brightness(0) invert(1);
}

.footer-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 25px;
}

/* QR Code Section */
.footer-scan-section {
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.footer-scan-section:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(76, 175, 80, 0.5);
}

.scan-qr-wrapper {
    background: white;
    padding: 8px;
    border-radius: 10px;
    flex-shrink: 0;
}

.qr-code {
    width: 70px;
    height: 70px;
    display: block;
}

.scan-text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.85rem;
    margin: 0;
    font-weight: 500;
}

/* App Download Section */
.app-download-section {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.app-store-btn {
    transition: transform 0.3s ease;
}

.app-store-btn:hover {
    transform: translateY(-5px);
}

.app-store-btn img {
    height: 45px;
    width: auto;
    border-radius: 8px;
}

/* Footer Links */
.footer-title {
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.title-icon {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.footer-links-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.footer-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-menu li {
    margin-bottom: 12px;
}

.footer-menu a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    padding: 8px 0;
}

.link-arrow {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
    color: #4CAF50;
    font-weight: bold;
}

.footer-menu a:hover {
    color: white;
    padding-left: 8px;
}

.footer-menu a:hover .link-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Social Section */
.social-section {
    margin-top: 35px;
}

.social-title {
    color: white;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.social-icons-wrapper {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.social-icon-link {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.social-icon-link:hover {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    border-color: #4CAF50;
    transform: translateY(-5px);
}

.social-icon {
    width: 22px;
    height: 22px;
    object-fit: contain;
    filter: brightness(0) invert(1);
}

/* Footer Bottom */
.footer-bottom {
    margin-top: 50px;
}

.footer-divider {
    border: none;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    margin-bottom: 25px;
}

.footer-copyright {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.copyright-text {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
    margin: 0;
}

.footer-bottom-links {
    display: flex;
    gap: 15px;
    align-items: center;
}

.footer-bottom-links a {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-bottom-links a:hover {
    color: #4CAF50;
}

.separator {
    color: rgba(255, 255, 255, 0.3);
}

/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
}

.back-to-top.visible {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.6);
}

/* Responsive Design */
@media (max-width: 992px) {
    .footer-links-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .footer-brand-section {
        padding-right: 0;
        margin-bottom: 40px;
    }
}

@media (max-width: 768px) {
    .footer-section {
        padding: 60px 0 20px;
    }

    .footer-copyright {
        flex-direction: column;
        text-align: center;
    }

    .footer-bottom-links {
        flex-direction: column;
        gap: 10px;
    }

    .separator {
        display: none;
    }

    .footer-title {
        font-size: 1.1rem;
    }

    .back-to-top {
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
    }
}

@media (max-width: 576px) {
    .app-download-section {
        flex-direction: column;
    }

    .app-store-btn img {
        width: 100%;
        height: auto;
    }

    .social-icons-wrapper {
        justify-content: center;
    }
}
</style>

<script>
// Back to Top Button
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });
    
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>
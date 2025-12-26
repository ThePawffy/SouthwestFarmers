<link rel="shortcut icon" type="image/x-icon"
      href="{{ asset(get_option('general')['favicon'] ?? 'assets/images/logo/favicon.png') }}">

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />

<!-- Slick Slider -->
<link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />

<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />

@stack('css')
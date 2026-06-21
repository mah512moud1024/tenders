<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', __('meta.title'))</title>
    <meta name="description" content="@yield('meta_description', __('meta.description'))">
    <meta name="keywords" content="@yield('meta_keywords', __('meta.keywords'))">
    <meta name="author" content="Buildariom">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('title', __('meta.title'))">
    <meta property="og:description" content="@yield('meta_description', __('meta.description'))">
    <meta property="og:image" content="{{ asset('storage/logo.png') }}">
    <meta property="og:site_name" content="Buildariom">
    <meta property="og:locale" content="{{ app()->getLocale() == 'ar' ? 'ar_AR' : 'en_US' }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ request()->url() }}">
    <meta name="twitter:title" content="@yield('title', __('meta.title'))">
    <meta name="twitter:description" content="@yield('meta_description', __('meta.description'))">
    <meta name="twitter:image" content="{{ asset('storage/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/favicon.png') }}">

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "Buildariom",
      "url": "https://buildariom.com",
      "logo": "{{ asset('storage/logo.png') }}",
      "sameAs": [
        "https://www.facebook.com/buildariom",
        "https://www.twitter.com/buildariom",
        "https://www.linkedin.com/company/buildariom"
      ]
    }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/public.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --accent: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }
        .overflow-prevent { overflow-x: hidden; }
        body { font-family: 'Figtree', sans-serif; scroll-behavior: smooth; }
        .gradient-bg { background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); }
        .section-padding { padding: 5rem 0; }
        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
        .nav-active { color: var(--primary); font-weight: 600; }
        .testimonial-card { background: white; border-radius: 12px; position: relative; overflow: hidden; }
        .testimonial-card::before {
            content: "\201C";
            position: absolute; top: -10px; left: 20px;
            font-size: 80px; color: #e5e7eb; font-family: Georgia, serif; z-index: 0;
        }
        .pricing-card { transition: all 0.3s ease; border: 2px solid #e5e7eb; }
        .pricing-card.featured { border-color: var(--primary); transform: scale(1.05); }
        .pricing-card:hover { border-color: var(--primary); }
        .faq-item { border-bottom: 1px solid #e5e7eb; }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .faq-item.active .faq-answer { max-height: 500px; }
        [dir="rtl"] .testimonial-card::before { left: auto; right: 20px; }
        @media (max-width: 1000px) {
            .section-padding { padding: 3rem 0; }
            .pricing-card.featured { transform: scale(1); }
        }
    </style>
</head>
<body class="font-sans text-gray-900 dark:bg-gray-900 antialiased">
<div x-data="{ open: false }" class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 top-0 shadow-sm" x-data="{ open: false, scrolled: false }"
         @scroll.window="scrolled = window.scrollY > 50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-2">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('storage/logo.png') }}" alt="{{ config('app.name') }} Logo" class="h-8 sm:h-10 md:h-12 lg:h-14 w-auto object-contain">
                    </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8 rtl:space-x-reverse">
                    <a href="/#home" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('Home')}}</a>
                    <a href="/#about" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('About')}}</a>
                    <a href="/#how-it-works" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('How It Works')}}</a>
                    <a href="/#pricing" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('Pricing')}}</a>
                    <a href="/#testimonials" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('Testimonials')}}</a>

                    <!-- Language Switcher -->
                    @if (app()->getLocale() == 'ar')
                        <a href="{{ route('language.switch', 'en') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">English</a>
                    @else
                        <a href="{{ route('language.switch', 'ar') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">العربية</a>
                    @endif

                    @auth
                        <a href="{{ route('filament.account.pages.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium px-4 transition-colors">{{ __('Log in') }}</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">{{ __('Register') }}</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden flex items-center space-x-4 rtl:space-x-reverse">
                    @if (app()->getLocale() == 'ar')
                        <a href="{{ route('language.switch', 'en') }}" class="text-sm font-medium text-gray-600">EN</a>
                    @else
                        <a href="{{ route('language.switch', 'ar') }}" class="text-sm font-medium text-gray-600">AR</a>
                    @endif

                    <button @click="open = !open" class="text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" class="lg:hidden py-4 border-t border-gray-200" x-cloak>
                <div class="flex flex-col space-y-4">
                    <a href="/#home" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('Home')}}</a>
                    <a href="/#about" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('About')}}</a>
                    <a href="/#how-it-works" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('How It Works')}}</a>
                    <a href="/#pricing" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('Pricing')}}</a>
                    <a href="/#testimonials" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">{{__('Testimonials')}}</a>

                    <div class="pt-4 border-t border-gray-200">
                        @auth
                            <a href="{{ route('filament.account.pages.dashboard') }}" class="block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-center transition-colors">{{ __('Dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="block text-gray-700 hover:text-indigo-600 font-medium py-2 transition-colors text-center">{{ __('Log in') }}</a>
                            <a href="{{ route('register') }}" class="block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-center transition-colors">{{ __('Register') }}</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <a href="{{ url('/') }}" class="flex items-center mb-4">
                        <img src="{{ asset('storage/logo.png') }}" alt="{{ config('app.name') }} Logo" class="h-12 md:h-16 w-auto object-contain">
                    </a>
                    <p class="text-gray-400 max-w-md">
                        {{__('The leading platform for construction tenders in the UAE. Connect with verified contractors and streamline your project bidding process.')}}
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">{{__('Resources')}}</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{__('About Us')}}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{__('Contact')}}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">{{__('Legal')}}</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{__('Privacy Policy')}}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{__('Terms & Conditions')}}</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>© {{ date('Y') }} {{ config('app.name', 'Buildariom') }}. {{__('All rights reserved.')}}</p>
            </div>
        </div>
    </footer>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({ duration: 800, once: true, offset: 0 });

        // Nav link active state
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        function updateActiveNavLink() {
            let scrollY = window.pageYOffset;
            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');
                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    navLinks.forEach(link => {
                        link.classList.remove('nav-active');
                        if (link.getAttribute('href') === `#${sectionId}`) link.classList.add('nav-active');
                    });
                }
            });
        }
        window.addEventListener('scroll', updateActiveNavLink);
    });

    document.addEventListener('livewire:navigated', () => { AOS.init({ duration: 800, once: true, offset: 0 }); });
    document.addEventListener('livewire:updated', () => { AOS.refreshHard(); });
</script>

<livewire:verify-phone-modal />
@livewireScripts

</body>
</html>

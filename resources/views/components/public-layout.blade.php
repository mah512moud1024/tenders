<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />


    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/public.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --accent: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        body {
            font-family: 'Figtree', sans-serif;
            scroll-behavior: smooth;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }

        .section-padding {
            padding: 5rem 0;
        }

        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .nav-active {
            color: var(--primary);
            font-weight: 600;
        }

        .testimonial-card {
            background: white;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: """;
            position: absolute;
            top: -10px;
            left: 20px;
            font-size: 80px;
            color: #e5e7eb;
            font-family: Georgia, serif;
            z-index: 0;
        }

        .pricing-card {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .pricing-card.featured {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .pricing-card:hover {
            border-color: var(--primary);
        }

        .faq-item {
            border-bottom: 1px solid #e5e7eb;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
        }

        /* RTL support */
        [dir="rtl"] .testimonial-card::before {
            left: auto;
            right: 20px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .section-padding {
                padding: 3rem 0;
            }

            .pricing-card.featured {
                transform: scale(1);
            }
        }
    </style>

</head>
<body class="font-sans text-gray-900  dark:bg-gray-900 antialiased">
<div x-data="{ open: false }" class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 top-0 shadow-sm" x-data="{ open: false, scrolled: false }"
         @scroll.window="scrolled = window.scrollY > 50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">T</div>
                        <span class="self-center text-2xl font-bold text-gray-900">{{ config('app.name', 'Tenders Platform') }}</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 rtl:space-x-reverse">
                    <a href="#home" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">About</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">How It Works</a>
                    <a href="#why-us" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Why Us</a>
                    <a href="#pricing" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Pricing</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Testimonials</a>

                    <!-- Language Switcher -->
                    @if (app()->getLocale() == 'ar')
                        <a href="{{ route('language.switch', 'en') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">English</a>
                    @else
                        <a href="{{ route('language.switch', 'ar') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">العربية</a>
                    @endif

                    @auth
                        <a href="{{ route('filament.account.pages.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors">{{ __('Log in') }}</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">{{ __('Register') }}</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center space-x-4 rtl:space-x-reverse">
                    <!-- Language Switcher -->
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
            <div x-show="open" class="md:hidden py-4 border-t border-gray-200" x-cloak>
                <div class="flex flex-col space-y-4">
                    <a href="#home" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Home</a>
                    <a href="#about" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">About</a>
                    <a href="#how-it-works" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">How It Works</a>
                    <a href="#why-us" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Why Us</a>
                    <a href="#pricing" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Pricing</a>
                    <a href="#testimonials" @click="open = false" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors nav-link">Testimonials</a>

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
    <main >

        {{ $slot }}
    </main>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="bg-gray-800   text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse mb-4">
                        <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">T</div>
                        <span class="self-center text-2xl font-bold">{{ config('app.name', 'Tenders Platform') }}</span>
                    </a>
                    <p class="text-gray-400 max-w-md">
                        The leading platform for construction tenders in the UAE. Connect with verified contractors and streamline your project bidding process.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>© {{ date('Y') }} {{ config('app.name', 'Tenders Platform') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

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
                        if (link.getAttribute('href') === `#${sectionId}`) {
                            link.classList.add('nav-active');
                        }
                    });
                }
            });
        }

        window.addEventListener('scroll', updateActiveNavLink);
    });
</script>
</body>
</html>

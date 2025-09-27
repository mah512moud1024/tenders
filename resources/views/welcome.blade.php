<x-public-layout>
    @section('title', __('meta.title'))
<!-- old hero section -->


<!-- Hero Section -->
<section id="home" class=" bg-[#1010100d] pt-24 pb-16 md:pt-32 md:pb-24 overflow-hidden">
    <div style="
    background-image: url('{{ asset('bg-top-lines.svg') }}');
    background-repeat: no-repeat;
    background-position: top left;
    background-size: cover;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"

    >

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="{{ app()->getLocale() === 'ar' ? 'lg:order-1' : '' }}" data-aos="fade-left" data-aos-delay="400">
                <div class="relative">

                    <img src="{{ asset('hero-main.png.webp') }}" alt="{{ __('hero.alt') }}" class="">
                </div>
            </div>
            <div class="{{ app()->getLocale() === 'ar' ? 'lg:order-2 text-right' : 'text-left' }}" data-aos="fade-right" data-aos-delay="200">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                    {{ __('hero.title') }} <span class="text-indigo-600">{{ __('hero.title2') }}</span> {{ __('hero.title3') }}
                </h1>
                <p class="mt-6 text-lg md:text-xl text-gray-600 leading-relaxed">
                    {{ __('hero.subtitle') }}
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 {{ app()->getLocale() === 'ar' ? 'sm:justify-end' : '' }}">
                    <a href="{{ route('filament.account.auth.login') }}"
                       class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all transform hover:-translate-y-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ __('cta.post_tender') }}</span>
                    </a>
                    <a href="{{ route('filament.account.auth.login') }}"
                       class="inline-flex items-center justify-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium px-6 py-3 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ __('cta.browse') }}</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section-padding bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __('about.title') }}</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">{{ __('about.text') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center p-6 card-hover rounded-xl" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('features.trusted.title') }}</h3>
                <p class="text-gray-600">{{ __('features.trusted.text') }}</p>
            </div>

            <div class="text-center p-6 card-hover rounded-xl" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('features.fast.title') }}</h3>
                <p class="text-gray-600">{{ __('features.fast.text') }}</p>
            </div>

            <div class="text-center p-6 card-hover rounded-xl" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('features.compare.title') }}</h3>
                <p class="text-gray-600">{{ __('features.compare.text') }}</p>
            </div>

            <div class="text-center p-6 card-hover rounded-xl" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('features.manage.title') }}</h3>
                <p class="text-gray-600">{{ __('features.manage.text') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="section-padding bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __('how.title') }}</h2>
        </div>

        <div class="relative">
            <!-- Connecting Line -->
            <div class="hidden md:block absolute top-1/2 left-0 right-0 h-0.5 bg-indigo-200 transform -translate-y-1/2"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach (['step1','step2','step3'] as $step)
                    <div class="relative text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 200 }}">
                        <div class="mx-auto w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center mb-6 relative z-10 border-4 border-white">
                            <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                {{ __('how.' . $step . '.num') }}
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('how.' . $step . '.title') }}</h3>
                        <p class="text-gray-600">{{ __('how.' . $step . '.text') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section id="why-us" class="section-padding bg-white" style="overflow-x: hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ __('why.title') }}</h2>
                <p class="text-lg text-gray-600 mb-8">{{ __('why.lead') }}</p>

                <div class="space-y-6">
                    @foreach (['secure','verified','support','savings'] as $k)
                        <div class="flex items-start space-x-4 rtl:space-x-reverse" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-xl">{{ __('why.' . $k . '.icon') }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('why.' . $k . '.title') }}</h3>
                                <p class="text-gray-600">{{ __('why.' . $k . '.text') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 p-8 rounded-2xl text-white" data-aos="fade-left" data-aos-delay="300">
                <div class="text-center">
                    <h3 class="text-2xl font-bold mb-4">{{ __('quick_stats.title') }}</h3>
                    <div class="text-5xl font-bold mb-2">{{ __('quick_stats.lead') }}</div>
                    <p class="text-indigo-100 mb-6">{{ __('quick_stats.text') }}</p>
                    <a href="{{ route('filament.account.auth.login') }}" class="inline-block bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('cta.post_tender') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="section-padding bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __('plans.title') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach(['basic','standard','enterprise'] as $plan)
                <div class="pricing-card p-8 bg-white rounded-2xl {{ $plan == 'standard' ? 'featured' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 200 }}">
                    @if($plan == 'standard')
                        <div class="bg-indigo-600 text-white text-sm font-bold py-1 px-4 rounded-full inline-block mb-4">Most Popular</div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ __('plans.' . $plan . '.title') }}</h3>
                        <div class="mt-4 flex items-baseline">
                            <span class="text-4xl font-bold text-gray-900">{{ __('plans.' . $plan . '.price') }}</span>
                            @if($plan != 'enterprise')
                                <span class="ml-2 text-gray-600">/month</span>
                            @endif
                        </div>
                        <p class="mt-2 text-gray-600">{{ __('plans.' . $plan . '.desc') }}</p>
                    </div>

                    <ul class="space-y-4 mb-8">
                        @foreach(range(1,3) as $i)
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-3 rtl:mr-0 rtl:ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">{{ __('plans.' . $plan . '.feature' . $i) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 rounded-lg font-medium transition-colors
                        {{ $plan == 'standard' ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }}">
                        {{ __('plans.' . $plan . '.button') }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section-padding bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __('faq.title') }}</h2>
        </div>

        <div class="space-y-4" x-data="{ active: 1 }">
            @foreach(range(1,4) as $i)
                <div class="faq-item bg-gray-50 rounded-lg overflow-hidden"
                     :class="{ 'active': active === {{ $i }} }"
                     x-data="{ open: {{ $i === 1 ? 'true' : 'false' }} }">
                    <button class="w-full text-left p-6 flex justify-between items-center font-medium text-gray-900 hover:bg-gray-100 transition-colors"
                            @click="open = !open; active = open ? {{ $i }} : null">
                        <span>{{ __('faq.q' . $i) }}</span>
                        <svg class="h-5 w-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer px-6 pb-6 text-gray-600" x-show="open" x-cloak>
                        {{ __('faq.a' . $i) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="section-padding bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __('testimonials.title') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="200">
            @foreach(range(1,3) as $t)
                <div class="testimonial-card p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            {{ substr(__('testimonials.author' . $t), 0, 1) }}
                        </div>
                        <div class="ml-4 rtl:ml-0 rtl:mr-4">
                            <div class="font-bold text-gray-900">{{ __('testimonials.author' . $t) }}</div>
                            <div class="text-sm text-gray-600">{{ __('testimonials.role' . $t) }}</div>
                        </div>
                    </div>
                    <p class="text-gray-700 relative z-10">"{{ __('testimonials.text' . $t) }}"</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- CTA Section -->
<section class="py-16 bg-indigo-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4" data-aos="fade-up">Ready to get started?</h2>
        <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Join thousands of companies already using our platform to find the perfect partners for their projects.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
                {{ __('cta.post_tender') }}
            </a>
            <a href="{{ route('filament.account.auth.login') }}" class="inline-flex items-center justify-center bg-transparent border border-white text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors">
                {{ __('cta.browse') }}
            </a>
        </div>
    </div>
</section>

</x-public-layout>

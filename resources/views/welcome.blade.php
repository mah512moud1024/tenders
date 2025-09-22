<x-public-layout>
    <!-- Hero Section -->
    <section id="hero" class="bg-gray-900 text-white pt-32 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/az-subtle.png');"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-4">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary-400 to-primary-600">
                    {{ __('landing.hero.title') }}
                </span>
            </h1>
            <p class="max-w-3xl mx-auto text-lg md:text-xl text-gray-300 mb-8">
                {{ __('landing.hero.subtitle') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('tenders.index') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg transition-transform transform hover:scale-105">
                    {{ __('landing.hero.cta_business') }}
                </a>
                <a href="{{ route('register') }}" class="inline-block bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg transition-transform transform hover:scale-105">
                    {{ __('landing.hero.cta_client') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ __('landing.features.title') }}</h2>
                <p class="max-w-2xl mx-auto mt-4 text-lg text-gray-600 dark:text-gray-400">{{ __('landing.features.subtitle') }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-8 bg-white dark:bg-gray-900 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 dark:bg-primary-900/50 mx-auto mb-4">
                        <x-heroicon-o-document-plus class="h-8 w-8 text-primary-600 dark:text-primary-400"/>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ __('landing.features.item1_title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('landing.features.item1_desc') }}</p>
                </div>
                <!-- Feature 2 -->
                <div class="text-center p-8 bg-white dark:bg-gray-900 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 dark:bg-primary-900/50 mx-auto mb-4">
                        <x-heroicon-o-users class="h-8 w-8 text-primary-600 dark:text-primary-400"/>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ __('landing.features.item2_title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('landing.features.item2_desc') }}</p>
                </div>
                <!-- Feature 3 -->
                <div class="text-center p-8 bg-white dark:bg-gray-900 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 dark:bg-primary-900/50 mx-auto mb-4">
                        <x-heroicon-o-shield-check class="h-8 w-8 text-primary-600 dark:text-primary-400"/>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ __('landing.features.item3_title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('landing.features.item3_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ __('landing.how.title') }}</h2>
                <p class="max-w-2xl mx-auto mt-4 text-lg text-gray-600 dark:text-gray-400">{{ __('landing.how.subtitle') }}</p>
            </div>
            <div class="relative">
                <!-- Desktop Timeline -->
                <div class="hidden md:block absolute w-px h-full bg-gray-200 dark:bg-gray-700 left-1/2 transform -translate-x-1/2"></div>
                <!-- Step 1 -->
                <div class="md:flex md:justify-between md:items-center w-full mb-8">
                    <div class="md:w-5/12"></div>
                    <div class="z-10 flex items-center justify-center w-12 h-12 bg-primary-600 rounded-full text-white font-bold text-lg">1</div>
                    <div class="md:w-5/12 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ __('landing.how.step1_title') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('landing.how.step1_desc') }}</p>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="md:flex md:flex-row-reverse md:justify-between md:items-center w-full mb-8">
                    <div class="md:w-5/12"></div>
                    <div class="z-10 flex items-center justify-center w-12 h-12 bg-primary-600 rounded-full text-white font-bold text-lg">2</div>
                    <div class="md:w-5/12 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ __('landing.how.step2_title') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('landing.how.step2_desc') }}</p>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="md:flex md:justify-between md:items-center w-full mb-8">
                    <div class="md:w-5/12"></div>
                    <div class="z-10 flex items-center justify-center w-12 h-12 bg-primary-600 rounded-full text-white font-bold text-lg">3</div>
                    <div class="md:w-5/12 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ __('landing.how.step3_title') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('landing.how.step3_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="bg-primary-700">
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold leading-tight text-white">{{ __('landing.cta.title') }}</h2>
                <p class="mb-6 font-light text-primary-100 md:text-lg">{{ __('landing.cta.subtitle') }}</p>
                <a href="{{ route('register') }}" class="text-primary-700 bg-white hover:bg-primary-50 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-white dark:hover:bg-gray-200 focus:outline-none dark:focus:ring-primary-800">{{ __('landing.cta.button') }}</a>
            </div>
        </div>
    </section>
</x-public-layout>

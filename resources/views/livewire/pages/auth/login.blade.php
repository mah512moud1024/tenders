<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.public-layout')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Always redirect to the correct role-based panel — never use redirectIntended
        // which can send users to stale/wrong URLs like /admin/dashboard
        $user = Auth::user();
        $dashboardRoute = ($user && $user->hasRole('admin'))
            ? 'filament.admin.pages.dashboard'
            : 'filament.account.pages.dashboard';

        $this->redirect(route($dashboardRoute), navigate: false);
    }
}; ?>

<div class="overflow-prevent bg-gradient-to-br from-gray-50 to-indigo-50 pt-24 pb-16 min-h-screen flex items-center">
    {{-- CSS animations that play once on load and never hide content again --}}
    <style>
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .anim-fade-right {
            animation: fadeInRight 0.8s ease-out both;
        }
        .anim-fade-left {
            animation: fadeInLeft 0.8s ease-out both;
            animation-delay: 0.2s;
        }
        .anim-fade-up-1 { animation: fadeInUp 0.6s ease-out both; animation-delay: 0.15s; }
        .anim-fade-up-2 { animation: fadeInUp 0.6s ease-out both; animation-delay: 0.3s; }
        .anim-fade-up-3 { animation: fadeInUp 0.6s ease-out both; animation-delay: 0.45s; }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Left Column - Illustration and Info -->
            <div class="{{ app()->getLocale() === 'ar' ? 'lg:order-2' : '' }} anim-fade-right">
                <div class="max-w-md mx-auto lg:mx-0">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ __('Welcome Back') }}
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        {{ __('Sign in to access your account and continue managing your tenders efficiently.') }}
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 rtl:space-x-reverse anim-fade-up-1">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="px-2">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('Secure Access') }}</h3>
                                <p class="text-gray-600">{{ __('Your data is protected with enterprise-grade security.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 rtl:space-x-reverse anim-fade-up-2">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="px-2">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('Fast & Efficient') }}</h3>
                                <p class="text-gray-600">{{ __('Quick access to all your tenders and bids in one place.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 rtl:space-x-reverse anim-fade-up-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="px-2">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('Connect with Contractors') }}</h3>
                                <p class="text-gray-600">{{ __('Access a network of verified contractors and suppliers.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Login Form -->
            <div class="{{ app()->getLocale() === 'ar' ? 'lg:order-1' : '' }} anim-fade-left">
                <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md mx-auto lg:mx-0 card-hover">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">{{ __('Sign In') }}</h2>
                        <p class="text-gray-600 mt-2">{{ __('Access your account to continue') }}</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form wire:submit="login" class="space-y-6">
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <x-text-input
                                    wire:model="form.email"
                                    id="email"
                                    class="block w-full pl-10 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                    type="email"
                                    name="email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="your@email.com"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <x-text-input
                                    wire:model="form.password"
                                    id="password"
                                    class="block w-full pl-10 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    wire:model="form.remember"
                                    id="remember"
                                    type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                >
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    {{ __('Remember me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" href="{{ route('password.request') }}" wire:navigate>
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                {{ __('Sign In') }}
                            </x-primary-button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-gray-600">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors" wire:navigate>
                                    {{ __('Create Your Account') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

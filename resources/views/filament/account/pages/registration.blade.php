<x-filament-panels::page>
    <div class="fi-page-registration mx-auto max-w-4xl space-y-8">
        @if (!$success)
            <div class="space-y-2 text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-4xl">
                    {{ __('Create Your Account') }}
                </h1>
                <p class="text-lg text-gray-500 dark:text-gray-400">
                    {{ __('Join our platform to access a world of construction opportunities.') }}
                </p>
            </div>

            <x-filament::section>
                <x-slot name="heading">
                    {{ __('Registration Details') }}
                </x-slot>

                {{ $this->form }}
            </x-filament::section>

            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Already have an account?') }}
                    <a href="{{ filament()->getLoginUrl() }}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                        {{ __('Sign in here') }}
                    </a>
                </p>
            </div>
        @else
            <div class="rounded-lg bg-gray-50 p-8 text-center dark:bg-gray-800/50">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                    <x-heroicon-o-check class="h-6 w-6 text-green-600 dark:text-green-400" />
                </div>

                <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Registration Successful!') }}
                </h2>

                <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                    @if ($this->data['account_type'] === 'client')
                        {{ __('Your client account has been created. Please proceed to the dashboard.') }}
                    @else
                        {{ __('Your business account has been created and is pending admin approval. You will be notified shortly.') }}
                    @endif
                </p>

                <div class="mt-6">
                    <x-filament::button
                        tag="a"
                        :href="filament()->getDashboardUrl()"
                        size="lg"
                    >
                        {{ __('Go to Dashboard') }}
                    </x-filament::button>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>

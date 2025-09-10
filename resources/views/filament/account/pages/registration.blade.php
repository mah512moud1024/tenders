<x-filament-panels::page>
    <div class="fi-page-registration max-w-4xl mx-auto">
        @if (!$success)
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white">
                    Create Your Account
                </h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Join our platform to access tenders and services
                </p>
            </div>

            <x-filament::section>
                {{ $this->form }}
            </x-filament::section>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <a href="{{ filament()->getLoginUrl() }}" class="font-medium text-primary-600 hover:text-primary-500">
                        Sign in
                    </a>
                </p>
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/20">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                    Registration Successful!
                </h2>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    @if ($this->data['account_type'] === 'client')
                        Your client account has been created successfully. You can now browse and participate in tenders.
                    @else
                        Your business account has been created and is pending approval. You will be notified once your account is approved.
                    @endif
                </p>

                <div class="mt-6">
                    <a
                        href="{{ route('tenders.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto"
                    >
                        Continue to Tenders
                    </a>
                </div>
            </div>
        @endif
    </div>

    <style>
        .fi-page-registration {
            padding: 2rem 1rem;
        }

        @media (min-width: 640px) {
            .fi-page-registration {
                padding: 3rem 2rem;
            }
        }
    </style>
</x-filament-panels::page>

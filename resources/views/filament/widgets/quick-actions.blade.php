<div class="">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{__('Quick Actions')}}</h3>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <!-- Browse Tenders -->
        {{-- Browse Tenders --}}
        <a
            href="{{ route('filament.account.pages.browse-tenders') }}"
            class="flex flex-col sm:flex-row items-center sm:items-start p-4 bg-primary-50 dark:bg-primary-900/20 hover:bg-primary-100 dark:hover:bg-primary-900/30 rounded-lg border border-primary-200 dark:border-primary-700 transition-colors group "
        >
            <!-- Icon -->
            <div
                class="flex-shrink-0 w-12 h-12 bg-primary-600 dark:bg-primary-500 rounded-lg flex items-center justify-center mb-3 sm:mb-0 {{ app()->getLocale() === 'ar' ? 'ml-0 sm:ml-4' : 'mr-0 sm:mr-4' }} group-hover:bg-primary-700 dark:group-hover:bg-primary-400 transition-colors"
            >
                <x-heroicon-o-briefcase class="w-6 h-6 text-white" />
            </div>

            <!-- Text -->
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-700 dark:group-hover:text-primary-300 {{ app()->getLocale() === 'ar' ? 'text-sm' : 'text-base' }}">
                    {{ __('Browse Tenders') }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 hidden sm:block">
                    {{ __('Find new projects') }}
                </p>
            </div>
        </a>

        <!-- Submit Quote -->
        <a
            href="{{ route('filament.account.pages.browse-tenders') }}"
            class="flex flex-col sm:flex-row items-center sm:items-start p-4 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-700 transition-colors group "
        >
            <div
                class="flex-shrink-0 w-12 h-12 bg-green-600 dark:bg-green-500 rounded-lg flex items-center justify-center mb-3 sm:mb-0 {{ app()->getLocale() === 'ar' ? 'ml-0 sm:ml-4' : 'mr-0 sm:mr-4' }} group-hover:bg-green-700 dark:group-hover:bg-green-400 transition-colors"
            >
                <x-heroicon-o-currency-dollar class="w-6 h-6 text-white" />
            </div>

            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-green-700 dark:group-hover:text-green-300 {{ app()->getLocale() === 'ar' ? 'text-sm' : 'text-base' }}">
                    {{ __('Submit Quote') }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 hidden sm:block">
                    {{ __('Apply for tenders') }}
                </p>
            </div>
        </a>

        <!-- View Invoices -->
        <a
            href="{{ route('filament.account.resources.invoices.index') }}"
            class="flex flex-col sm:flex-row items-center sm:items-start p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-700 transition-colors group"
        >
            <div
                class="flex-shrink-0 w-12 h-12 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center mb-3 sm:mb-0 {{ app()->getLocale() === 'ar' ? 'ml-0 sm:ml-4' : 'mr-0 sm:mr-4' }} group-hover:bg-blue-700 dark:group-hover:bg-blue-400 transition-colors"
            >
                <x-heroicon-o-document-text class="w-6 h-6 text-white" />
            </div>

            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300 {{ app()->getLocale() === 'ar' ? 'text-sm' : 'text-base' }}">
                    {{ __('View Invoices') }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 hidden sm:block">
                    {{ __('Manage payments') }}
                </p>
            </div>
        </a>

        <!-- Your Profile -->

        <a
            href="{{ route("filament.account.pages.profile") }}"
            class="flex flex-col sm:flex-row items-center sm:items-start p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg border border-purple-200 dark:border-purple-700 transition-colors group "
        >
            <div
                class="flex-shrink-0 w-12 h-12 bg-purple-600 dark:bg-purple-500 rounded-lg flex items-center justify-center mb-3 sm:mb-0 {{ app()->getLocale() === 'ar' ? 'ml-0 sm:ml-4' : 'mr-0 sm:mr-4' }} group-hover:bg-purple-700 dark:group-hover:bg-purple-400 transition-colors"
            >
                <x-heroicon-o-user class="w-6 h-6 text-white" />
            </div>

            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-700 dark:group-hover:text-purple-300 {{ app()->getLocale() === 'ar' ? 'text-sm' : 'text-base' }}">
                    {{ __('Your Profile') }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 hidden sm:block">
                    {{ __('Update information') }}
                </p>
            </div>
        </a>
    </div>
</div>

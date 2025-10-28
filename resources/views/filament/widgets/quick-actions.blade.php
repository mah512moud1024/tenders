<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{__('Quick Actions')}}</h3>

    <div class="grid grid-cols-2 gap-4">
        <!-- Browse Tenders -->
        <a
            href="{{ route('filament.account.pages.browse-tenders') }}"
            class="flex items-center p-4 bg-primary-50 dark:bg-primary-900/20 hover:bg-primary-100 dark:hover:bg-primary-900/30 rounded-lg border border-primary-200 dark:border-primary-700 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-primary-600 dark:bg-primary-500 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }} group-hover:bg-primary-700 dark:group-hover:bg-primary-400 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-700 dark:group-hover:text-primary-300">{{__('Browse Tenders')}}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{__('Find new projects')}}</p>
            </div>
        </a>

        <!-- Submit Quote -->
        <a
            href="{{ route('filament.account.pages.browse-tenders') }}"
            class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-700 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-green-600 dark:bg-green-500 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }} group-hover:bg-green-700 dark:group-hover:bg-green-400 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-green-700 dark:group-hover:text-green-300">{{__('Submit Quote')}}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{__('Apply for tenders')}}</p>
            </div>
        </a>

        <!-- View Invoices -->
        <a
            href='{{ route("filament.account.resources.invoices.index") }}'
            class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-700 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }} group-hover:bg-blue-700 dark:group-hover:bg-blue-400 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300">{{__('View Invoices')}}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{__('Manage payments')}}</p>
            </div>
        </a>

        <!-- Your Profile -->
        <a
            href="{{ route("filament.account.pages.profile") }}"
            class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg border border-purple-200 dark:border-purple-700 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-purple-600 dark:bg-purple-500 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }} group-hover:bg-purple-700 dark:group-hover:bg-purple-400 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-700 dark:group-hover:text-purple-300">{{__('Your Profile')}}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{__('Update information')}}</p>
            </div>
        </a>
    </div>
</div>

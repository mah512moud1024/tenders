<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

    <div class="grid grid-cols-2 gap-4">
        <!-- Browse Tenders -->
        <a
            href="{{ route('filament.account.pages.browse-tenders') }}"
            class="flex items-center p-4 bg-primary-50 hover:bg-primary-100 rounded-lg border border-primary-200 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center mr-4 group-hover:bg-primary-700 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 group-hover:text-primary-700">Browse Tenders</h4>
                <p class="text-sm text-gray-600">Find new projects</p>
            </div>
        </a>

        <!-- Submit Quote -->
        <a
            href="{{ route('filament.account.pages.browse-tenders') }}"
            class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-700 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 group-hover:text-green-700">Submit Quote</h4>
                <p class="text-sm text-gray-600">Apply for tenders</p>
            </div>
        </a>

        <!-- View Invoices -->
        <a
            href='{{ route("filament.account.resources.invoices.index") }}'
            class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-700 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 group-hover:text-blue-700">View Invoices</h4>
                <p class="text-sm text-gray-600">Manage payments</p>
            </div>
        </a>

        <!-- Your Profile -->
        <a
            href="#"
            class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition-colors group"
        >
            <div class="flex-shrink-0 w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-700 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 group-hover:text-purple-700">Your Profile</h4>
                <p class="text-sm text-gray-600">Update information</p>
            </div>
        </a>
    </div>
</div>

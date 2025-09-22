<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('filament.account.pages.browse-tenders') }}" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-400 mb-4 inline-block">
                &larr; Back to Tenders
            </a>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white sm:text-4xl mb-2">
                {{ $tender->title }}
            </h1>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full dark:bg-blue-900/50 dark:text-blue-300">{{ $tender->tender_type }}</span>
                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full dark:bg-green-900/50 dark:text-green-300">{{ $tender->category->name }}</span>
                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full dark:bg-purple-900/50 dark:text-purple-300">{{ $tender->work_type }}</span>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full dark:bg-yellow-900/50 dark:text-yellow-300">{{ $tender->city->name }}</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-md dark:bg-gray-800 overflow-hidden">
            <div class="p-6 space-y-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Description</h2>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $tender->description }}</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Project Details</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        @if($tender->building_area)
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Building Area</div>
                                <div class="font-semibold text-gray-700 dark:text-gray-300">{{ $tender->building_area }} m²</div>
                            </div>
                        @endif
                        @if($tender->land_area)
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Land Area</div>
                                <div class="font-semibold text-gray-700 dark:text-gray-300">{{ $tender->land_area }} m²</div>
                            </div>
                        @endif
                        @if($tender->floors)
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Floors</div>
                                <div class="font-semibold text-gray-700 dark:text-gray-300">{{ $tender->floors }}</div>
                            </div>
                        @endif
                        <div>
                            <div class="text-gray-500 dark:text-gray-400">Project Type</div>
                            <div class="font-semibold text-gray-700 dark:text-gray-300">{{ Str::title(str_replace('_', ' ', $tender->project_type)) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Footer -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Closing In</div>
                    <div class="text-lg font-bold text-red-600 dark:text-red-500">
                        {{ $tender->closing_date->diffForHumans() }}
                    </div>
                </div>
                <div>
                    @auth
                        @if(Auth::user()->canSubmitQuote())
                            {{ $this->submitQuoteAction }}
                        @else
                            <span class="inline-block px-6 py-3 text-sm font-medium text-gray-500 bg-gray-200 rounded-lg dark:bg-gray-700 dark:text-gray-400 cursor-not-allowed" title="You may have reached your quote limit or your account is not authorized for this tender type.">
                                {{ __('Cannot Submit Quote') }}
                            </span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 text-sm font-medium text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">{{ __('Login to Submit') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <x-filament-actions::modals />
</div>


<div>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{__('Available Tenders')}}</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{__('Browse through our available projects and submit your quotes')}}
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{__('Showing')}} {{ $tenders->firstItem() ?? 0 }}  {{__('to')}} {{ $tenders->lastItem() ?? 0 }} {{__('of')}} {{ $tenders->total() }} {{__('results')}}
                        </div>
                        <button
                            wire:click="resetFilters"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        >
                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{__('Reset Filters')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Filters Sidebar -->
                <div class="w-full lg:w-80 flex-shrink-0">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{__('Filters')}}</h3>

                        <!-- Search -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{__('Search Tenders')}}
                            </label>
                            <input
                                type="text"
                                wire:model.live="search"
                                placeholder="{{__('Search by title or description...')}}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                            >
                        </div>

                        <!-- Category Multi-select -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{__('Categories')}}
                            </label>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model.live="selectedCategories"
                                            value="{{ $category->id }}"
                                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600"
                                        >
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __($category->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- City Multi-select -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{__('Cities')}}
                            </label>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($cities as $city)
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model.live="selectedCities"
                                            value="{{ $city->id }}"
                                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600"
                                        >
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __($city->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tender Type Multi-select -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{__('Tender Types')}}
                            </label>
                            <div class="space-y-2">
                                @foreach($tenderTypes as $key => $value)
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model.live="selectedTenderTypes"
                                            value="{{ $key }}"
                                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600"
                                        >
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __($value) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Work Type Multi-select -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{__('Work Types')}}
                            </label>
                            <div class="space-y-2">
                                @foreach($workTypes as $key => $value)
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model.live="selectedWorkTypes"
                                            value="{{ $key }}"
                                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600"
                                        >
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __($value) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tenders List -->
                <div class="flex-1">
                    <!-- Sort Options -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{__('Sort by:')}}</span>
                                <button
                                    wire:click="sortBy('created_at')"
                                    class="text-sm font-medium {{ $sortBys === 'created_at' ? 'text-primary-600 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}"
                                >
                                    {{__('Newest')}}
                                    @if($sortBys === 'created_at')
                                        <span class="ml-1">{{ $sortDirections === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>

                            </div>

                            <!-- Add a visual indicator that sorting is working -->
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{__('Sorted by:')}} {{ $sortBys === 'created_at' ? 'Newest' : 'Closing Date' }}
                                ({{ $sortDirections === 'asc' ? 'Ascending' : 'Descending' }})
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        @forelse($tenders as $tender)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col h-full">
                                <div class="p-8 flex flex-col flex-1 justify-between">
                                    <div class="flex-1">
                                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4">
                                            <div class="flex-1 min-w-0">
                                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                                    <a href="{{ route('filament.account.pages.view-tender', $tender) }}">
                                                        {{ $tender->title }}
                                                    </a>
                                                </h2>
                                                <div class="flex flex-wrap gap-1.5 mb-3">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                                        {{ __($tenderTypes[$tender->tender_type] ?? $tender->tender_type) }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                                        {{ __($tender->category->name) }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300">
                                                        {{ __($workTypes[$tender->work_type] ?? $tender->work_type) }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">
                                                        {{ __($tender->city->name) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-right sm:text-right flex-shrink-0 bg-red-50 dark:bg-red-950/20 px-3 py-2 rounded-lg border border-red-100 dark:border-red-900/30 w-full sm:w-auto">
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{__('Closing Date')}}</div>
                                                <div class="text-base font-bold text-red-600 dark:text-red-400">
                                                    {{ $tender->closing_date->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                    {{ $tender->closing_date->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description Preview -->
                                        <div class="mb-4">
                                            <div class="prose prose-sm max-w-none dark:prose-invert text-gray-600 dark:text-gray-300 line-clamp-3">
                                                {!! Str::limit(strip_tags($tender->description), 200) !!}
                                            </div>
                                        </div>

                                        <!-- Project Details -->
                                        <div class="flex flex-wrap gap-x-4 gap-y-2 mb-6 text-sm">
                                            @if($tender->building_area)
                                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                    <span>{{ $tender->building_area }} {{__('m² Building Area')}}</span>
                                                </div>
                                            @endif

                                            @if($tender->land_area)
                                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                                                    </svg>
                                                    <span>{{ $tender->land_area }} {{__('m² Land Area')}} </span>
                                                </div>
                                            @endif

                                            @if($tender->floors)
                                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                    <span>{{ $tender->floors }} {{__('Floors')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700 mt-auto">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{__('Posted by')}}: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $tender->user->business_name ?? $tender->user->full_name }}</span>
                                        </div>

                                        <div>
                                            @auth
                                                @if($canSubmitQuotes[$tender->id] && !$hasAlreadyQuoted[$tender->id])
                                                    <a
                                                        href="{{ route('filament.account.pages.view-tender', $tender) }}"
                                                        class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                    >
                                                        {{__('Submit Quote')}}
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 cursor-not-allowed">
                                                       @if($hasAlreadyQuoted[$tender->id])
                                                             {{__('Already Submitted')}}
                                                         @elseif(!Auth::user()->approved)
                                                             {{__('Pending Approval')}}
                                                         @elseif(!Auth::user()->canSubmitQuote())
                                                             {{__('Quote Limit Reached')}}
                                                         @else
                                                             {{__('Cannot Bid')}}
                                                         @endif
                                                 </span>
                                                @endif
                                            @else
                                                <a
                                                    href="{{ route('login') }}"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                >
                                                    {{__('Login to Submit Quote')}}
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center col-span-full">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{__('No tenders found')}}</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    {{__('Try adjusting your filters or check back later for new tenders')}}
                                </p>
                                <button
                                    wire:click="resetFilters"
                                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    {{__('Reset Filters')}}
                                </button>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($tenders->hasPages())
                        <div class="mt-8">
                            {{ $tenders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

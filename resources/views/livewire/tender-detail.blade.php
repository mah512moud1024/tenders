<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('filament.account.pages.browse-tenders') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    {{__('Browse Tenders')}}
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ Str::limit($tender->title, 50) }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Header -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ $tender->title }}
                            </h1>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                    {{ $tenderTypes[$tender->tender_type] ?? $tender->tender_type }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                    {{ $tender->category->name }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300">
                                    {{ $workTypes[$tender->work_type] ?? $tender->work_type }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">
                                    {{ $tender->city->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">{{__('Project Description')}}</h2>
                    <div class="prose prose-lg max-w-none dark:prose-invert text-gray-600 dark:text-gray-300">
                        {!! $tender->description !!}
                    </div>
                </div>

                <!-- Project Details -->
                <div class="p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">{{__('Project Specifications')}}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($tender->building_area)
                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }}">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{__('Building Area')}}</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $tender->building_area }} {{__('m²')}}</div>
                                </div>
                            </div>
                        @endif

                        @if($tender->land_area)
                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }}">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{__('Land Area')}}</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $tender->land_area }} {{__('m²')}}</div>
                                </div>
                            </div>
                        @endif

                        @if($tender->floors)
                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }}">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{__('Number of Floors')}}</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $tender->floors }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-lg flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }}">
                                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{__('Closing Date')}}</div>
                                <div class="text-lg font-semibold text-red-600 dark:text-red-400">{{ $tender->closing_date->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $tender->closing_date->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                @if($tender->specifications->isNotEmpty())
                    <div class="p-8 border-t border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">{{__('Attachments')}}</h2>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($tender->specifications as $spec)
                                <li class="py-3 flex items-center justify-between text-sm">
                                    <div class="flex items-center flex-1 w-0">
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        <span class="ml-2 flex-1 w-0 truncate text-gray-700 dark:text-gray-300">
                                            {{ $spec->original_name }} ({{ number_format($spec->file_size / (1024 * 1024), 2) }} MB)
                                        </span>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="{{ route('tenders.specifications.download', $spec) }}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                                            {{__('Download')}}
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Action Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{__('Submit Your Quote')}}</h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{__('Status')}}</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                            {{__('Active')}}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{__('Time Remaining')}}</span>
                        <span class="text-sm font-medium text-red-600 dark:text-red-400">
                            {{ $tender->closing_date->diffForHumans() }}
                        </span>
                    </div>

                    <div class="pt-4">
                        {{ $this->submitQuoteAction }}
                    </div>
                </div>
            </div>

            <!-- Client Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{__('Client Information')}}</h3>

                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{__('Posted By')}}</div>
                        <div class="font-medium text-gray-900 dark:text-white">
                            {{ $tender->user->business_name ?? $tender->user->full_name }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{__('Location')}}</div>
                        <div class="font-medium text-gray-900 dark:text-white">
                            {{ $tender->city->name }}, {{ $tender->city->country->name }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 dark:text-gray-400"{{__('Tender Posted')}}></div>
                        <div class="font-medium text-gray-900 dark:text-white">
                            {{ $tender->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-filament-actions::modals />
</div>

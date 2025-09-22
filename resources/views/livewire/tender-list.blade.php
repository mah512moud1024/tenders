


    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Available Tenders</h1>
            <p class="text-gray-600">Browse through our available projects and submit your quotes</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="Search tenders..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select wire:model.live="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- City -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <select wire:model.live="city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tender Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tender Type</label>
                    <select wire:model.live="tenderType" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        @foreach($tenderTypes as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Work Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Work Type</label>
                    <select wire:model.live="workType" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Work Types</option>
                        @foreach($workTypes as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Showing {{ $tenders->firstItem() }} to {{ $tenders->lastItem() }} of {{ $tenders->total() }} results
                </div>
                <button wire:click="resetFilters" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                    Reset Filters
                </button>
            </div>
        </div>

        <!-- Tenders List -->
        <div class="grid grid-cols-4 gap-4">

            @forelse($tenders as $tender)
                <div class="bg-white rounded-lg shadow-md overflow-hidden col-span-4 ">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $tender->title }}</h2>
                                <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                    {{ $tenderTypes[$tender->tender_type] }}
                                </span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                    {{ $tender->category->name }}
                                </span>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                    {{ $workTypes[$tender->work_type] }}
                                </span>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                                    {{ $tender->city->name }}
                                </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 mb-1">Closing Date</div>
                                <div class="text-lg font-semibold text-red-600">
                                    {{ $tender->closing_date->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-4">{{ Str::limit($tender->description, 200) }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            @if($tender->building_area)
                                <div>
                                    <div class="text-sm text-gray-500">Building Area</div>
                                    <div class="font-semibold">{{ $tender->building_area }} m²</div>
                                </div>
                            @endif

                            @if($tender->land_area)
                                <div>
                                    <div class="text-sm text-gray-500">Land Area</div>
                                    <div class="font-semibold">{{ $tender->land_area }} m²</div>
                                </div>
                            @endif

                            @if($tender->floors)
                                <div>
                                    <div class="text-sm text-gray-500">Floors</div>
                                    <div class="font-semibold">{{ $tender->floors }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                Posted by: {{ $tender->user->business_name ?? $tender->user->full_name }}
                            </div>

                            <div>
                                @auth
                                    @if($canSubmitQuotes[$tender->id])
                                        <a
                                            href="{{ route('filament.account.pages.view-tender', $tender) }}"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                        >
                                            Submit Quote
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-500">
                    @if(!Auth::user()->approved)
                                                Your account is pending approval
                                            @else
                                                Your account type cannot bid on this tender
                                            @endif
                </span>
                                    @endif
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                                    >
                                        Login to Submit Quote
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="text-2xl text-gray-400 mb-2">No tenders found</div>
                    <p class="text-gray-500 mb-4">Try adjusting your filters or check back later for new tenders</p>
                    <button wire:click="resetFilters" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Reset Filters
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $tenders->links() }}
        </div>
    </div>


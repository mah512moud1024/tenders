<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Submit Quote for: {{ $tender->title }}</h1>
        <p class="text-gray-600">Complete the form below to submit your quote for this tender</p>
    </div>

    @if($success)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <p>Your quote has been submitted successfully!</p>
            <a href="{{ route('tenders.index') }}" class="text-green-800 underline">Return to tenders</a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-6">
            <form wire:submit.prevent="submitQuote">
                <!-- Amount -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                        Quote Amount (SAR)
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        wire:model="amount"
                        id="amount"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your quote amount"
                    >
                    @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Proposal -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="proposal">
                        Proposal Details
                    </label>
                    <textarea
                        wire:model="proposal"
                        id="proposal"
                        rows="6"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Describe your proposal in detail..."
                    ></textarea>
                    @error('proposal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Documents -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Supporting Documents (PDF, Word, Excel)
                    </label>
                    <input
                        type="file"
                        wire:model="documents"
                        multiple
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    @error('documents.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Submit Quote
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

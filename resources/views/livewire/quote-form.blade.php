<div class="container mx-auto max-w-3xl px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{__('Submit Quote for:')}} {{ $tender->title }}</h1>
        <p class="text-gray-600 dark:text-gray-400">{{__('Complete the form below to submit your quote for this tender')}}</p>
    </div>

    @if($success)
        <div class="rounded-lg bg-green-50 p-6 text-center dark:bg-green-900/20">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                <x-heroicon-o-check class="h-6 w-6 text-green-600 dark:text-green-400" />
            </div>
            <h2 class="mt-4 text-xl font-semibold text-green-800 dark:text-green-300">{{__('Your quote has been submitted successfully!')}}</h2>
            <p class="mt-2 text-sm text-green-700 dark:text-green-400">{{__('It is now under review by our team. You will be notified of its status.')}}</p>
            <a href="{{ route('tenders.index') }}" class="mt-4 inline-block text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">{{__('Return to tenders')}}</a>
        </div>
    @elseif($authorizationError)
        <div class="rounded-lg bg-red-50 p-6 text-center dark:bg-red-900/20">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/20">
                <x-heroicon-o-x-circle class="h-6 w-6 text-red-600 dark:text-red-400" />
            </div>
            <h2 class="mt-4 text-xl font-semibold text-red-800 dark:text-red-300">{{__('Access Denied')}}</h2>
            <p class="mt-2 text-sm text-red-700 dark:text-red-400">{{ $authorizationError }}</p>
            <a href="{{ route('tenders.index') }}" class="mt-4 inline-block text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">{{__('Return to tenders')}}</a>
        </div>
    @else
        <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
            <form wire:submit.prevent="submitQuote">
                <!-- Amount -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-bold text-gray-700 dark:text-gray-300" for="amount">
                        {{__('Quote Amount (AED)')}}
                    </label>
                    <input type="number" step="0.01" wire:model="amount" id="amount" class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700" placeholder="{{__('Enter your quote amount')}}">
                    @error('amount') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Proposal -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-bold text-gray-700 dark:text-gray-300" for="proposal">
                        {{__('Proposal Details')}}
                    </label>
                    <textarea wire:model="proposal" id="proposal" rows="6" class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700" placeholder="{{__('Describe your proposal in detail...')}}"></textarea>
                    @error('proposal') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Documents -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-bold text-gray-700 dark:text-gray-300">
                        {{__('Supporting Documents (PDF, Word, Excel, DWG, DWF, DXF)')}}
                    </label>
                    <input type="file" wire:model="documents" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.dwg,.dwf,.dxf" class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-primary-50 file:py-2 file:px-4 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-700/20 dark:file:text-primary-300 dark:hover:file:bg-primary-700/30">
                    @error('documents.*') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <x-primary-button type="submit">
                        {{__('Submit Quote')}}
                    </x-primary-button>
                </div>
            </form>
        </div>
    @endif
</div>

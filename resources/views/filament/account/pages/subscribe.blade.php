<x-filament-panels::page>

    {{-- Show a message if the user already has a subscription --}}
    @if($currentSubscription)
        <div class="p-4 mb-6 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <span class="font-medium">{{ __('Subscription Status') }}:</span>
            {{ __('You have a') }} <span class="font-bold">{{ $currentSubscription->status }}</span> {{ __('subscription to the') }} <strong>{{ $currentSubscription->plan->name }}</strong> {{ __('plan') }}.
        </div>
    @endif

    {{-- Pricing Grid --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($plans as $plan)
            <div class="flex flex-col p-6 text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">{{ $plan->name }}</h3>
                <span class="mr-2 text-5xl font-extrabold">{{$plan->id }}</span>
                <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">{{ $plan->description }}</p>
                <div class="flex items-baseline justify-center my-8">
                    <span class="mr-2 text-5xl font-extrabold">${{ number_format($plan->price, 2) }}</span>


                    <span class="text-gray-500 dark:text-gray-400">/{{ $plan->interval }}</span>
                </div>

                {{-- Feature List --}}
                <ul role="list" class="flex-grow mb-8 space-y-4 text-left rtl:text-right">
                    <li class="flex items-center space-x-3 rtl:space-x-reverse">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500" />
                        <span>
                           {{ $plan->free_quotes == -1 ? __('Unlimited quotes') : ($plan->free_quotes . __(' quotes')) }}
                        </span>
                    </li>
                    <li class="flex items-center space-x-3 rtl:space-x-reverse">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500" />
                        <span>
                           {{ $plan->listing_limit == 0 ? __('Unlimited tender listings') : ($plan->listing_limit . __(' tender listings')) }}
                        </span>
                    </li>
                    @if($plan->featured_listing)
                        <li class="flex items-center space-x-3 rtl:space-x-reverse">
                            <x-heroicon-o-check-circle class="w-5 h-5 text-green-500" />
                            <span>{{ __('Featured Listing Priority') }}</span>
                        </li>
                    @endif
                </ul>

                {{-- This button calls the "choosePlan" action from your PHP class --}}
                {{-- It is only shown if the user doesn't have a current subscription --}}
                @if(!$currentSubscription)
                    @if(!empty($plan->id)) {{ $this->getAction('choosePlan')(['plan_id' => $plan->id]) }}@endif

                @endif
            </div>
        @empty
            <p>{{ __('No subscription plans are available at the moment.') }}</p>
        @endforelse
            <style>body > div.fi-layout > div.fi-main-ctn > main > div > div.fi-page-header-main-ctn > header > div.fi-header-actions-ctn > div {display: none}</style>
    </div>

</x-filament-panels::page>


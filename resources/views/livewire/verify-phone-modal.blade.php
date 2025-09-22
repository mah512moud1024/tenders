<div x-data="{
        show: @entangle('showModal'),
        timer: null,
        expiresAt: @entangle('expiresAt'),
        countdown: 60,
        init() {
            this.$watch('show', value => {
                if (value) {
                    this.startCountdown();
                } else {
                    clearInterval(this.timer);
                }
            });
        },
        startCountdown() {
            if (this.expiresAt) {
                this.updateCountdown();
                this.timer = setInterval(() => {
                    this.updateCountdown();
                }, 1000);
            }
        },
        updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const remaining = this.expiresAt - now;
            this.countdown = remaining > 0 ? remaining : 0;
            if (this.countdown <= 0) {
                clearInterval(this.timer);
            }
        }
     }"
     x-show="show"
     x-on:keydown.escape.window="show = false"
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay, now more transparent -->
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-900/75" aria-hidden="true"
             @click="$wire.closeModal()"></div>

        <!-- This span is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl dark:bg-gray-800">

            <!-- Close 'X' Button -->
            <button @click="$wire.closeModal()" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <span class="sr-only">Close</span>
                <x-heroicon-o-x-mark class="w-6 h-6" />
            </button>

            <h3 class="text-2xl font-bold text-center text-gray-900 dark:text-white" id="modal-title">
                {{ __('Phone Verification') }}
            </h3>
            <p class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">
                {{ __('A 6-digit code has been sent to your phone. Enter it below to continue.') }}
            </p>

            <form wire:submit.prevent="verifyCode" class="mt-6 space-y-4">
                <div class="relative">
                    <label for="code" class="sr-only">{{ __('Verification Code') }}</label>
                    <input wire:model="code" type="text" id="code" name="code"
                           x-bind:disabled="countdown <= 0"
                           class="block w-full text-2xl text-center tracking-[1em] bg-gray-100 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50"
                           maxlength="6" placeholder="------" required>

                    <!-- Countdown Timer -->
                    <div class="absolute inset-y-0 right-4 flex items-center text-sm font-medium"
                         :class="{ 'text-red-500': countdown <= 10, 'text-gray-500 dark:text-gray-400': countdown > 10 }">
                        <span x-show="countdown > 0" x-text="`0:${countdown.toString().padStart(2, '0')}`"></span>
                        <span x-show="countdown <= 0">{{ __('Expired') }}</span>
                    </div>
                </div>

                @if($error)
                    <p class="text-sm text-center text-red-600 dark:text-red-400">{{ $error }}</p>
                @endif

                @if(session('status'))
                    <p class="text-sm text-center text-green-600 dark:text-green-400">{{ session('status') }}</p>
                @endif


                <div class="pt-4 space-y-3">
                    <x-primary-button class="w-full justify-center" x-bind:disabled="countdown <= 0">
                        {{ __('Verify Account') }}
                    </x-primary-button>

                    <button type="button"
                            wire:click="resendCode"
                            class="w-full text-sm font-medium text-center text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300"
                            x-show="countdown <= 0">
                        {{ __("Request a new code") }}
                    </button>

                    <button type="button" @click="$wire.closeModal()" class="w-full text-sm font-medium text-center text-gray-600 underline dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                        {{ __('Cancel and start over') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


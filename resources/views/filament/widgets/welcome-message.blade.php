<div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-xl shadow-sm p-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-primary-100 opacity-90">
                @php
                    $hour = now()->hour;
                    if ($hour < 12) {
                        $greeting = 'Good morning';
                    } elseif ($hour < 17) {
                        $greeting = 'Good afternoon';
                    } else {
                        $greeting = 'Good evening';
                    }
                @endphp
                {{ $greeting }}! Ready to manage your construction projects?
            </p>
        </div>
        <div class="hidden md:block">
            <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

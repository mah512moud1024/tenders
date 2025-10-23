<x-filament-panels::page>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold tracking-tight sm:text-2xl">
                {{ $this->getTitle() }}
            </h2>
            {{ \Filament\Facades\Filament::renderHook('panels::page.header-end') }}
        </div>
    </x-slot>

    @include('filament.widgets.advertising-slider')

    {{ \Filament\Facades\Filament::renderHook('panels::page.content.start') }}

    <div
        class="fi-dashboard-widgets-ctn grid grid-cols-1 gap-6 lg:grid-cols-2"
        @php
            $columns = $this->getColumns();
        @endphp
        @if (is_int($columns))
            style="
                grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
            "
        @endif
    >
        @foreach ($this->getVisibleWidgets() as $widget)
            @livewire($widget)
        @endforeach
    </div>

    {{ \Filament\Facades\Filament::renderHook('panels::page.content.end') }}
</x-filament-panels::page>

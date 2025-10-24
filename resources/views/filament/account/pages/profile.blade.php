<x-filament-panels::page>
    <div>
        <form wire:submit="save" id="form" class="grid gap-y-6">

            {{ $this->form }}

            <x-filament::actions :actions="$this->getFormActions()" alignment="center" class="mt-4" />
        </form>

        @if(in_array(auth()->user()->type, ['consultant', 'contractor', 'subcontractor', 'supplier']))
            <x-filament::section class="mt-6">
                <x-slot name="heading">
                    License Status
                </x-slot>

                <div class="space-y-4">
                    @php
                        $isLicenseExpired = auth()->user()->license_expiry && auth()->user()->license_expiry->isPast();
                    @endphp

                    <div class="flex items-center justify-between p-4 rounded-lg @if($isLicenseExpired) bg-danger-50 border border-danger-200 @else bg-success-50 border border-success-200 @endif">
                        <div>
                            <p class="font-medium @if($isLicenseExpired) text-danger-700 @else text-success-700 @endif">
                                Trading License Status:
                                @if($isLicenseExpired)
                                    <span class="font-bold">EXPIRED</span>
                                @else
                                    <span class="font-bold">VALID</span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Expiry Date: {{ auth()->user()->license_expiry?->format('M d, Y') ?? 'Not set' }}
                            </p>
                        </div>
                        @if($isLicenseExpired)
                            <x-filament::icon-button
                                icon="heroicon-o-exclamation-triangle"
                                color="danger"
                                tooltip="Your license has expired. Please upload a new valid license."
                            />
                        @else
                            <x-filament::icon-button
                                icon="heroicon-o-check-circle"
                                color="success"
                            />
                        @endif
                    </div>
                </div>
            </x-filament::section>
        @endif
    </div>



    <x-filament-actions::modals />
</x-filament-panels::page>

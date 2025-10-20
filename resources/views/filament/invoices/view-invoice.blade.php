<x-filament-panels::page>

    <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg min-h-[80vh] print:p-0 print:shadow-none print:min-h-0 print:bg-white" id="invoice-container">

        <header class="mb-12 border-b-4 border-gray-200 pb-4">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-extrabold text-primary-600">INVOICE</h1>
                    <p class="text-xl mt-1 text-gray-700 font-semibold">#{{ $this->record->invoice_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-800">Your Company Name</p>
                    <p class="text-sm text-gray-600">123 Business Street, City, ZIP</p>
                    <p class="text-sm text-gray-600">Email: info@example.com</p>
                    <p class="text-sm text-gray-600">Phone: (123) 456-7890</p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-2 gap-10 mb-12 text-sm">
            <div>
                <h2 class="font-bold text-base text-gray-700 mb-2">INVOICE TO:</h2>
                <p class="font-semibold text-gray-800">{{ $this->record->user?->name ?? 'Customer Name' }}</p>
                <p class="text-gray-600">{{ $this->record->user?->email ?? 'N/A' }}</p>
            </div>
            <div class="text-right space-y-1">
                <p><strong>Invoice ID:</strong> {{ $this->record->invoice_number }}</p>
                <p><strong>Issue Date:</strong> {{ $this->record->issue_date->format('M d, Y') }}</p>
                <p><strong>Due Date:</strong> {{ $this->record->due_date->format('M d, Y') }}</p>
                <p class="mt-4 text-xl font-bold text-green-600">Status: {{ strtoupper($this->record->status) }}</p>
            </div>
        </div>

        <div class="mb-12">
            <h2 class="font-bold text-lg text-gray-700 mb-4 border-b pb-2">Summary</h2>

            <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-sm text-gray-600">Transaction ID:</span>
                    <span class="text-sm font-medium text-gray-800">{{ $this->record->transaction_id }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-sm text-gray-600">Subtotal (Pre-Tax):</span>
                    <span class="text-sm font-medium text-gray-800">${{ number_format($this->record->amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-sm text-gray-600">Tax Amount:</span>
                    <span class="text-sm font-medium text-gray-800">${{ number_format($this->record->tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-sm text-gray-600 font-bold">INVOICE TOTAL:</span>
                    <span class="text-lg font-extrabold text-primary-600">${{ number_format($this->record->total_amount, 2) }}</span>
                </div>
            </div>

            @if($this->record->notes)
                <div class="mt-8 pt-4 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-700 mb-1">Notes:</h3>
                    <p class="text-sm text-gray-600">{{ $this->record->notes }}</p>
                </div>
            @endif
        </div>

        <footer class="mt-16 text-center text-xs text-gray-500 border-t pt-4">
            Thank you for your business. Please contact us if you have any questions.
        </footer>

    </div>

    @push('styles')
        <style>
            @media print {
                /* General styling for a clean print page */
                body {
                    margin: 0;
                    background-color: #fff !important;
                }

                /* Hide Filament's default header, sidebar, and page actions (Print button is in header actions but is covered by this) */
                /* The Print button is now hidden because the entire header area is hidden. This is desired. */
                .fi-header, .fi-sidebar, .fi-topbar, .fi-footer, .fi-page-actions {
                    display: none !important;
                }

                /* Ensure the main invoice container takes up the whole print page */
                #invoice-container {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    padding: 0 !important;
                    margin: 0 !important;
                    box-shadow: none !important;
                    min-height: auto !important;
                }

                /* FIX for white text: Force all text in the invoice container to black */
                #invoice-container, #invoice-container * {
                    color: #000 !important; /* Forces black text, overriding any light theme settings */
                    background-color: transparent !important; /* Ensures no weird backgrounds are printed */
                }

                /* Ensure borders are printed */
                #invoice-container .border-b,
                #invoice-container .border-t,
                #invoice-container .border-b-4 {
                    border-color: #000 !important;
                }
            }
        </style>
    @endpush

</x-filament-panels::page>

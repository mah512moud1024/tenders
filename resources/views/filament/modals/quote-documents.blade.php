<div>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        Attached Documents
    </h2>
    @if ($documents->count() > 0)
        <ul class="divide-y divide-gray-200 dark:divide-white/10">
            @foreach ($documents as $document)
                <li class="py-3 flex items-center justify-between">
                    <div class="flex items-center min-w-0">
                        {{-- Add flex-shrink-0 for robustness --}}

                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $document->original_name }}</span>
                    </div>
                    <a href="{{ route('quote.document.download', $document) }}"
                       download
                       class="inline-flex items-center gap-x-2 rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">

                        Download
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-gray-500 dark:text-gray-400">No documents were attached to this quote.</p>
    @endif
</div>

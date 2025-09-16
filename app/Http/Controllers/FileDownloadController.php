<?php

namespace App\Http\Controllers;

use App\Models\QuoteDocument;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDownloadController extends Controller
{
    /**
     * Handle the request to download a specific quote document.
     *
     * @param QuoteDocument $document
     * @return StreamedResponse
     */
    public function downloadQuoteDocument(QuoteDocument $document)
    {
        // Security Check: Does the logged-in user own the tender this quote belongs to?
        $tenderOwnerId = $document->quote->tender->user_id;

        if (auth()->id() !== $tenderOwnerId) {
            // If not, deny access.
            abort(403, 'Unauthorized');
        }

        // Check if the file actually exists in our private storage
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        // If all checks pass, serve the file as a download.
        return Storage::disk('private')->download($document->file_path, $document->original_name);
    }
}

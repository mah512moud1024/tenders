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
        $tenderOwnerId = $document->quote->tender->user_id;
        $quoteSubmitterId = $document->quote->user_id;
        $loggedInUserId = auth()->id();

        // 2. Define Authorization: Check if the logged-in user is either the Tender Owner OR the Quote Submitter
        $isTenderOwner = $loggedInUserId === $tenderOwnerId;
        $isQuoteSubmitter = $loggedInUserId === $quoteSubmitterId;

        if (!$isTenderOwner && !$isQuoteSubmitter) {
            // If the user is neither the owner of the tender nor the submitter of the quote, deny access.
            abort(403, 'Unauthorized: You are neither the tender owner nor the quote submitter.');
        }


        // Check if the file actually exists in our private storage
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        // If all checks pass, serve the file as a download.
        return Storage::disk('private')->download($document->file_path, $document->original_name);
    }
}

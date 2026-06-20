<?php

namespace App\Http\Controllers;

use App\Models\TenderSpecification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TenderSpecificationDownloadController extends Controller
{
    /**
     * Download the specified tender document/specification securely.
     *
     * @param TenderSpecification $specification
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(TenderSpecification $specification)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        $tender = $specification->tender;
        $isOwner = $user->id === $tender->user_id;
        $isAdmin = $user->hasRole('admin');

        // Check if tender is approved/published
        $isApproved = in_array($tender->status, ['published', 'assigned', 'completed']);

        $isAuthorized = false;

        if ($isAdmin) {
            // Admins can always download
            $isAuthorized = true;
        } elseif ($isOwner && $isApproved) {
            // Tender Owner can download after approval
            $isAuthorized = true;
        } else {
            // Other users can download if approved/published AND they are authorized to bid on this tender type
            if ($isApproved) {
                $requiredRole = match($tender->tender_type) {
                    'design' => 'consultant',
                    'construction' => 'contractor',
                    'supply' => 'supplier',
                    default => null,
                };
                
                if ($requiredRole && $user->hasRole($requiredRole) && $user->approved) {
                    $isAuthorized = true;
                }
            }
        }

        if (!$isAuthorized) {
            abort(403, 'Unauthorized: You do not have permission to download this document.');
        }

        // Save to s3 amazon server
        if (!Storage::disk('s3')->exists($specification->file_path)) {
            abort(404, 'File not found in storage.');
        }

        return Storage::disk('s3')->download($specification->file_path, $specification->original_name);
    }
}

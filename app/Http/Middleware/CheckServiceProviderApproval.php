<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckServiceProviderApproval
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user is a service provider and not approved
        if ($user && $user->hasAnyRole(['consultant','admin', 'contractor', 'supplier']) && !$user->approved) {
            return redirect()->route('account.pending');
        }

        return $next($request);
    }
}

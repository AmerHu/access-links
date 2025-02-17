<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AccessLink;

class PreventReusedLinks
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->route('token');

        $link = AccessLink::where('token', $token)->first();

        if (!$link || $link->used || now()->greaterThan($link->expires_at)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        // Mark the link as used
        $link->update(['used' => true]);

        return $next($request);
    }
}

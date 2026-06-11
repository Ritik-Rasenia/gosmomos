<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Symfony\Component\HttpFoundation\Response;

class TrackActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log modifying requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            // Exclude passwords from payload tracking
            $payload = $request->except(['password', 'password_confirmation', 'otp']);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => strtolower($request->method()) . '_request',
                'model_type' => $request->path(),
                'model_id' => null,
                'new_values' => $payload,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}

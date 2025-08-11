<?php

// app/Http/Middleware/ApiKeyMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        logger('API Key Middleware Triggered'); // Check Laravel logs
        logger('Received Key: ' . $request->header('X-API-KEY'));
        logger('Stored Key: ' . config('app.api_key'));

        $apiKey = config('app.api_key');

        if ($request->header('X-API-KEY') !== $apiKey) {
            logger('API Key Validation Failed');
            return response()->json(['message' => 'Invalid API Key'], 401);
        }

        logger('API Key Validation Passed');
        return $next($request);
    }
}

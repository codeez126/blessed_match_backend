<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect if not authenticated
        }

        $user = Auth::user();

        // Log user type and the requested permission
        Log::info('Permission Check', [
            'user_id' => $user->id,
            'user_type' => $user->type,
            'requested_permission' => $permission
        ]);

        // Skip permission check for super admins (type 2)
        if ($user->type == 2) {
            Log::info('Super Admin bypassed permission check');
            return $next($request);
        }

        // Check if the user has the required permission
        $hasPermission = $user->can($permission);
        Log::info('Permission Check Result', [
            'user_id' => $user->id,
            'permission' => $permission,
            'has_permission' => $hasPermission
        ]);

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.'); // Return 403 error if no permission
        }

        return $next($request);
    }
}

<?php

// app/Http/Middleware/CheckAdminOrOperator.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckAdminOrOperator
{
    public function handle($request, Closure $next)
    {
        Log::info('CheckAdminOrOperator middleware triggered by user: ' . auth()->user()?->role);
        $user = Auth::user();
        
        if ($user && in_array(strtolower($user->role ?? ''), ['admin', 'operator'])) {
            return $next($request);
        }

        abort(403, 'Action Unauthorized. Please contact your administrator.');
    }
}



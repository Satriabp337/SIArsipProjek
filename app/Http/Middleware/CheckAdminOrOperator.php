<?php

// app/Http/Middleware/CheckAdminOrOperator.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminOrOperator
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user && in_array(strtolower($user->role->name ?? ''), ['admin', 'operator'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}



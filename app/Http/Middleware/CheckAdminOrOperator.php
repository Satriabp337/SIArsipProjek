<?php

// app/Http/Middleware/CheckAdminOrOperator.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminOrOperator
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'operator'])) {
            return $next($request);
        } else {abort(403, 'Unauthorized');}
    }
}


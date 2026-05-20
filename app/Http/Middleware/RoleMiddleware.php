<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        if (!Auth::check()) {
            return redirect('/login');
        }
        $userRole = Auth::user()->role;
        $normalizedRoles = [];
        foreach ($roles as $role) {
            $normalizedRoles[] = $role;
            if ($role === 'responsable') {
                $normalizedRoles[] = 'responsble';
            } elseif ($role === 'responsble') {
                $normalizedRoles[] = 'responsable';
            }
        }

        if (!in_array($userRole, $normalizedRoles)) {
            abort(403);
        }
        return $next($request);
        
    }
}

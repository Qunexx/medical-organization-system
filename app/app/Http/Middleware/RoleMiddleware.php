<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\RoleEnum;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $allowedRoles = collect($roles)
            ->map(fn($role) => RoleEnum::fromName($role))
            ->filter();

        $userRole = $request->user()->role;

        if (!$allowedRoles->contains($userRole) || $allowedRoles->isEmpty()) {
            abort(403, 'Нет доступа');
        }

        return $next($request);
    }
}

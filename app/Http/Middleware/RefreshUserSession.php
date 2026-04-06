<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RefreshUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user()->load('role.menus');
            $role = $user->role;
            $menus = $role ? $role->menus : collect();

            session([
                'user_data' => [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $role?->name ?? '-',
                    'menus' => $menus->pluck('name')->toArray(),
                ]
            ]);
        }

        return $next($request);
    }
}

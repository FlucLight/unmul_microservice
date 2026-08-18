<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! in_array($request->user()->role, $roles)) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Akses ditolak. Anda tidak memiliki izin untuk fitur ini.'], 403);
            }

            return redirect()->back()->with('error', 'Akses ditolak. Fitur ini hanya untuk ' . implode(' atau ', array_map('ucfirst', $roles)) . '.');
        }

        return $next($request);
    }
}

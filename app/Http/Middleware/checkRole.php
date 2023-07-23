<?php

namespace App\Http\Middleware;

use App\Models\Karyawan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next, ...$roles): Response
    {
        $karyawan = $req->user();
        if(!$karyawan || !in_array($karyawan->role, $roles)) {
            return response()->json(['msg' => 'Unauthorized'], 401);
        }

        return $next($req);
    }
}

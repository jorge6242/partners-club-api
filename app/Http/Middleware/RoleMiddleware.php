<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{

    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!$request->user()->hasRole($role)) {
             return response()->json([
                'success' => false,
                'message' => 'No tiene autorizacion'
            ])->setStatusCode(401);
        }

        if($permission !== null && !$request->user()->can($permission)) {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos'
            ])->setStatusCode(401);
        }

        return $next($request);

    }
}

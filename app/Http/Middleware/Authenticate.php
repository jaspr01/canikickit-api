<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function redirectTo(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}

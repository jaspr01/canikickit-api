<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Fetches the authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        try {
            // Fetch the authenticated user
            $user = $request->user();

            // Return the user
            return $this->sendResponse(200, $user);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param int $status
     * @param mixed $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function sendResponse(int $status, mixed $data = null, ?string $message = null): JsonResponse
    {
        $response = [
            'success' => true,
            ...$data ? ['data' => $data] : [],
            ...$message ? ['message' => $message] : [],
        ];

        return response()->json($response, $status);
    }


    /**
     * error response method.
     *
     * @param int $status
     * @param string $error
     * @param array|null $errorMessages
     * @return JsonResponse
     */
    public function sendError(int $status, string $error, array $errorMessages = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
            ...!empty($errorMessages) ? ['data' => $errorMessages] : [],
        ];

        return response()->json($response, $status);
    }

    /**
     * Sends a 401 unauthenticated response
     *
     * @return JsonResponse
     */
    public function sendUnauthenticated(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.',
        ], 401);
    }
}

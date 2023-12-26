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
     * @param object|null $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function sendResponse(int $status, ?object $data = null, ?string $message = null): JsonResponse
    {
        $response = [
            'success' => true,
            ...$data ? ['data' => $data] : [],
            ...$message ? ['message' => $message] : [],
        ];

        return response()->json($response, $status);
    }


    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}

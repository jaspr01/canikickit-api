<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    private UserService $userService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Login api call
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            // Fetch the user for the given email
            $user = $this->userService->getUserByEmail($request->email);

            // Check if passwords match
            if (!password_verify($request->password, $user->password)) {
                return $this->sendError(401, 'Invalid credentials');
            }

            // Delete all the user's previous tokens (if any)
            $user->tokens()->delete();

            // Generate the access_token for the authenticated user
            $token = $this->userService->createUserAccessToken($user);

            // Return the access_token
            return $this->sendResponse(200, ['access_token' => $token]);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Register api call
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $this->userService->createUser($request);

        // TODO: send email verification email

        return $this->sendResponse(201);
    }
}

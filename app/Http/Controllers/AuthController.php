<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    // GET

    /**
     * Handles the GET /auth/email/verify/{id}/{hash} request
     *
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($request->id);

            // Check if the user email matches the hash
            if (!hash_equals(sha1($user->email), $request->hash)) {
                return $this->sendUnauthenticated();
            }

            // Check if email not already verified
            if ($user->hasVerifiedEmail()) {
                return $this->sendError(400, 'Email already verified');
            }

            // Mark the user as verified
            $user->markEmailAsVerified();

            // Call the Verified event (sends a confirmation mail?)
            event(new Verified($user));

            // Return success response 201
            return $this->sendResponse(200);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Handles the GET /auth/logout request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Delete the user's token
            $request->user()->currentAccessToken()->delete();

            // Return success response 200
            return $this->sendResponse(200);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    // POST

    /**
     * Handles the POST /auth/login request
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
     * Handles the POST /auth/register request
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            // Create the user
            $user = $this->userService->createUser($request);

            // Call the Registered event (send verification mail)
            event(new Registered($user));

            // Return success response 201
            return $this->sendResponse(201);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }
}

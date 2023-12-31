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
     * Handles the POST /email/verify/{id}/{hash} request
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
     * Handles the POST /logout request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Logout the user
            auth()->logout();

            // Return success response 200
            return $this->sendResponse(200);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    // POST

    /**
     * Handles the POST /login request
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (auth()->attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();

                return $this->sendResponse(200);
            }

            return $this->sendError(401, 'Invalid credentials');
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Handles the POST /register request
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

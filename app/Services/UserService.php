<?php

namespace App\Services;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ItemNotFoundException;

class UserService
{
    /**
     * Registers a new user
     *
     * @param RegisterRequest $request
     * @return User
     */
    public function createUser(RegisterRequest $request): User
    {
        return User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    /**
     * Creates a token for a given user
     *
     * @param Authenticatable | User $user
     * @return string
     */
    public function createUserAccessToken(Authenticatable|User $user): string
    {
        // Create a new token for the user
        $token = $user->createToken('access_token')->plainTextToken;

        // Explode the plainTextToken to get only the accessToken (format = "<databaseId>|<accessToken>")
        return explode('|', $token)[1];
    }

    /**
     * Fetches a user by email
     *
     * @param string $email
     * @return User
     * @throws ItemNotFoundException
     */
    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    /**
     * Fetches a user by id
     *
     * @param string $id
     * @return User
     */
    public function getUserById(string $id): User
    {
        return User::findOrFail($id);
    }
}

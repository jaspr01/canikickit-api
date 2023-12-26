<?php

namespace App\Services;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Registers a new user
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function createUser(RegisterRequest $request): void
    {
        User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register (UserRequest $request)
    {
        $validated = $request->validated();
        
        $user = User::firstOrCreate($validated);

        return [
            'status' => 'OK',
            'message' => 'User Created',
            'token' => $user->createToken("api token")->plainTextToken
        ];
    }

    public function login (LoginRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return [
                'status' => false,
                'message' => 'Email or password incorrect'
            ];
        }

        $user = User::where('email', $validated['email'])->first();

        return [
            'status' => 'OK',
            'message' => 'Loged in successfuly',
            'token' => $user->createToken("api token")->plainTextToken
        ];
    }
}

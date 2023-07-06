<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Validate the user's email and password and return api token if success
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if (!$user->isAdmin()){
                return response()->json([
                    'status' => 'Unauthorized'
                ], 401);
            }

            $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => new UserResource($user)
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'errors' => ['email' => 'Password does not match'],
        ], 422);
    }
}

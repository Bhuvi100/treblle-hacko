<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Register user and send token
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->validated();

        $input['password'] = Hash::make($input['password']);

        $user = User::forceCreate($input);

        $user->sendEmailVerificationNotification();
        $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => new UserResource($user)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('id'),
            (string) $user->getKey())) {
            return response()->json([
                'status' => 'Unauthorized'
            ], 401);
        }

        if (! hash_equals((string) $request->route('hash'),
            sha1($user->getEmailForVerification()))) {
            return response()->json([
                'status' => 'Unauthorized'
            ], 401);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}

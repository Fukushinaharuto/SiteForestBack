<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        if(Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'token' => $token,
            ], 200);
        }else{
            return response()->noContent(401);
        }
    }

    public function register(RegisterRequest $requst) 
    {
        $validatedData = $requst->validated();
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent(202);
    }

    public function search(Request $request)
    {
        $token = $request->bearerToken();
        try {
            $tokenRecord = PersonalAccessToken::findToken($token);
            return response()->json(['tokenExists' => (bool) $tokenRecord]);
        } catch (\Exception $e) {
            return response()->noContext(500);
        }
    }

}

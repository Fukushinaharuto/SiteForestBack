<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function store(RegisterRequest $requst) 
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
}

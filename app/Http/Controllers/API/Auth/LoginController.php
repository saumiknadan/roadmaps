<?php

namespace App\Http\Controllers\API\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }


        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => Auth::user(), 
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout(); 

        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return response()->json(['message' => 'Logged out successfully']);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validateReq = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );
        if ($validateReq->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateReq->errors()->all()
            ]);
        }

        $user = User::where('email', $request->email)->first();
        if ($user->status === 'blocked') {
            return response()->json([
                'status' => false,
                'message' => 'Your account has been blocked.'
            ], 403);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Logged in successfully',
                    'auth_token' => $user->createToken('token')->plainTextToken,
                    'token_type' => 'Bearer'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ]);
        }
    }
    
}

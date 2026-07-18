<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function user_profile()
    {
        $id = Auth::user()->id;
        $profile = User::where('id', $id)->first();
        return response()->json(
            [
                'status' => true,
                'profile' => $profile
            ]
        );
    }

    public function change_password(Request $request)
    {
        $validare_request = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);

        if ($validare_request->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validare_request->errors()
            ], 422);
        }

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid password'
            ], 400);
        }
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'New password must be different from current password.'
            ], 400);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        $user->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully. Please login again.'
        ]);
    }


    public function store(Request $req)
    {
        $validUser = Validator::make($req->all(), [
            'name' => 'required|between:3,20',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validUser->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validUser->errors()->all()
            ]);
        }

        $savedUser = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password
        ]);
        $savedUser->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
            'message' => 'Registration successful. Please check your email to verify your account.',
            'data' => [
                'id' => $savedUser->id,
                'name' => $savedUser->name,
                'email' => $savedUser->email,
                'email_verified' => false
            ]
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::where('role','customer')->get();
        return view('admin.users.users',compact('users'));
    }

    public function update_status(Request $request, User $user){
        $user->update([
            'status'=>$request->status
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Status updated successfully'
        ]);
    }
}

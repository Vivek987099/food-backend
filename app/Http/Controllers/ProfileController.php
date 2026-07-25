<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Profile::with('user')->where('user_id',Auth::user()->id)->first();
        return response()->json([
            'status'=>true,
            'profile'=>$profile
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profile =  Profile::create([
            'user_id'=>Auth::user()->id,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'state'=>$request->state,
            'pincode'=>$request->pincode,
            'address'=>$request->address
        ]);

        if(!$profile){
            return response()->json([
                'statue'=>false,
                'message'=>'Profile can not be create due to some reasons.'
            ]);
        }

        return response()->json([
            'status'=>true,
            'profile'=>$profile
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $token =  $request->user()->createToken('myApp')->plainTextToken;
            return response()->json([
            'success'=>true,
            'message'=>'User login successfully.',
            'token'=>$token
        ]);
        } 
        return response()->json([
            'success'=>false,
            'message'=>'email and password is incorrect', 
        ]);

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
}

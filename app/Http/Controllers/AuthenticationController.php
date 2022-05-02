<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthenticationController extends Controller
{
    //

    public function createAccount(Request $request){

        $data = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]
        );

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response([
            'status' => 'success',
            'user' => $user,
             'token' => $token
             ] , 200);
    }


    public function login(Request $request){
            
            $data = $request->validate(
                [
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:6',
                ]
            );
    
            if(!Auth::attempt($data)){
                return response([
                    'message' => 'Invalid credentials'
                ], 401);
            }
    
            $user = User::where('email', $request->email)->first();
 
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
        
            return response([
                'status' => 'success',
                'user' => $user,
                'token' => $user->createToken('tokens')->plainTextToken
            ], 200);
    }


    public function logout(Request $request){
        $request->user()->token()->delete();
        return response([
            'message' => 'Successfully logged out'
        ], 200);
    }


}
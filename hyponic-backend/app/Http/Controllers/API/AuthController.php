<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * User register
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        if(!$fields) {
            return ResponseFormatter::error(null, 'Invalid data input', 400);
        }

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        if(!$user) {
            return ResponseFormatter::error(null, 'Something went wrong', 500);
        }

        return ResponseFormatter::success([
            'user' => $user,
        ], 'Register succesful');
    }

    /**
     * User login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if(!$fields) {
            return ResponseFormatter::error(null, 'Invalid data input', 400);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return ResponseFormatter::error(null, 'Bad credentials', 404);
        }

        $token = $user->createToken('access_token')->plainTextToken;

        return ResponseFormatter::success([                              
            'user' => $user,
            'access_token' => $token
        ], 'Login successful');
    }

    /**
     * User logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $logout = Auth::user()->tokens()->delete();

        if(!$logout) {
            return ResponseFormatter::error(null, 'Something went wrong', 404);
        }

        return ResponseFormatter::success(null, 'Logout successful');
    }

    public function user() {
        return ResponseFormatter::success(
            Auth::user(),
            'Success get auth user data'
        );
    }
}


<?php

namespace App\Http\Controllers\V1;


use App\Http\Controllers\V1\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function loginPost(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'Validation error' => $validator->errors(),
                'status' => 500
            ];
            return response()->json($response, 501);
        }
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            $response = [
                'success' => false,
                'message' => 'Unauthorized',
                'status' => 401
            ];
            return response()->json($response, 401);
        }
        $user = Auth::user();
        $response = [
            'user' => $user,
            'success' => true,
            'status' => 200,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];
        return response()->json($response, 200);
    }


    public function registerPost(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'error' => $validator->errors(),
                'status' => 500
            ];
            return response()->json($response, 500);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            $response = [
                'user' => $user,
                'success' => true,
                'message' => 'user successfully created',
                'status' => 200,
            ];
            return response()->json($response, 201);
        }
        $response = [
            'user' => $user,
            'success' => false,
            'status' => 500,

        ];
        return response()->json($response, 501);
    }


    public function logout()
    {
        Auth::logout();
        $response = [
            "success" => true,
            "message" => "disconnected successfully",
            "status" => 200,
        ];
        return response()->json($response, 200);
    }


    // public function verificationMail()
    // {
    //     return view('auth.verify-email');
    // }

    // public function procedeMail(EmailVerificationRequest $request)
    // {
    //     $request->fulfill();
    //     return redirect()->route('get.place');
    // }
}

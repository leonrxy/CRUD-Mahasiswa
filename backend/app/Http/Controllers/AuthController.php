<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            // cek email sudah terdaftar //cek jumlah karakter password
            if ($errors->has('email')) {
                return response()->json(['error' => 'Email telah terdaftar.'], 422);
            }elseif ($errors->has('password')) {
                $errorMessage = $errors->first('password');
    if (str_contains($errorMessage, 'at least 6 characters')) {
        return response()->json(['error' => 'Password harus memiliki setidaknya 6 karakter.'], 422);
    }
            }

            return response()->json(['errors' => $errors], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        if (!$user) {
            // Return an error if user creation fails
            return response()->json(['error' => 'Failed to create user.'], 500);
        }

        return response()->json(['user' => $user, 'message' => 'Registrasi akun berhasil. Silakan login dengan akun yang telah diregistrasi.'], 201);
    } catch (\Throwable $th) {
        // Log the exception for further analysis
        \Log::error($th);

        // Return a generic error message to the client
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 200);
        }

        return response()->json(['error' => 'Email atau Password Salah.'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out successfully']);
    }
}

<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;  // user model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // authentication added
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; // validation added

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('chatapp')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('chatapp')->plainTextToken;

        return response()->json([
            'message' => 'User login successfully.',
            'token' => $token,
            'user' => $user,
        ]);
    }
}

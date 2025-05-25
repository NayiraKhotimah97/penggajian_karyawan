<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credential = $request->validate([
            'email'=> 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credential)) {
            return response()->json(['massage' => 'Credential Are Not Valid'], 401);
        }

        $user = auth()->user();

        return response()->json([
            'token' => $user->createToken('gajikaryawan')->plainTextToken
        ]);
    }
}

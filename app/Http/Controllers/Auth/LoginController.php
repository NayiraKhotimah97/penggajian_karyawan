<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Login user dan mendapatkan token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|XyzAbc1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credential Are Not Valid",
     *         @OA\JsonContent(
     *             @OA\Property(property="massage", type="string", example="Credential Are Not Valid")
     *         )
     *     )
     * )
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

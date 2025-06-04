<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * )
     */

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Logout user (revoke current token)",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully Logout"),
     *             @OA\Property(property="token", type="string", example="Token 1 has been revoked")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $token = $request->user()->currentAccessToken();
        $tokenId = $token->id;
        $token->delete();

        return response()->json([
            'message' => 'Successfully Logout',
            'token' => "Token {$tokenId} has been revoked"
        ]);
    }
}

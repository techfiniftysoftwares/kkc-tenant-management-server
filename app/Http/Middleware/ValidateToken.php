<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

// class ValidateToken
// {
//     public function handle(Request $request, Closure $next)
//     {
//         $token = $request->bearerToken();

//         if (!$token) {
//             return response()->json([
//                 'status' => 'error',
//                 'success' => false,
//                 'message' => 'Access token missing',
//             ], 401);
//         }

//         $tokenRecord = Token::where('id', $token)->first();

//         if (!$tokenRecord || $tokenRecord->revoked) {

//             return response()->json([
//                 'status' => 'error',
//                 'success' => false,
//                 'message' => 'Invalid or revoked access token',
//             ], 401);
//         }

//         if (Carbon::parse($tokenRecord->expires_at)->isPast()) {

//             return response()->json([
//                 'status' => 'error',
//                 'success' => false,
//                 'message' => 'Access token expired',
//             ], 401);
//         }

//         Auth::setUser($tokenRecord->user);

//         return $next($request);
//     }
// }




class ValidateToken
{
    protected $tokenRepository;
    protected $refreshTokenRepository;

    public function __construct(TokenRepository $tokenRepository, RefreshTokenRepository $refreshTokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Access token missing',
            ], 401);
        }

        try {
            $tokenId = $this->getTokenId($token);
            $tokenRecord = $this->tokenRepository->find($tokenId);

            if (!$tokenRecord || $tokenRecord->revoked) {
                return response()->json([
                    'status' => 401,
                    'success' => false,
                    'message' => 'Invalid or revoked access token',
                ], 401);
            }

            if ($tokenRecord->expires_at && $tokenRecord->expires_at->isPast()) {
                return response()->json([
                    'status' => 401,
                    'success' => false,
                    'message' => 'Access token expired',
                ], 401);
            }

            $user = $tokenRecord->user;
            $request->setUserResolver(function () use ($user) {
                return $user;
            });

            return $next($request);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Invalid access token',
            ], 401);
        }
    }

    protected function getTokenId($token)
    {
        $parts = explode('.', $token);
        $tokenId = json_decode(base64_decode($parts[1]), true)['jti'];
        return $tokenId;
    }
}

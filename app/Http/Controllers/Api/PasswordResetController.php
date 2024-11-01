<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use \Illuminate\Foundation\Auth\ResetsPasswords;
use App\Jobs\SendPasswordChangeConfirmationEmail;


class PasswordResetController extends Controller
{


    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // dd($user);

        if (!$user || !$user->isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or user account is inactive.',
            ], 400);
        }



        // Send the password reset email
        $status = Password::sendResetLink($request->only('email'));

        // Check the status of the password reset email
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset link has been sent to your email.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to send password reset link. Please try again later.',
            ], 422);
        }
    }




  
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password); // Use Hash::make() instead of bcrypt()
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Retrieve the user by email
            $user = User::where('email', $request->email)->first();

            // Send email using a job
            SendPasswordChangeConfirmationEmail::dispatch($user);
            
            return response()->json(['success' => true, 'message' => 'Password has been reset']);
        } else {
            throw ValidationException::withMessages([
                'password' => [trans($status)],
            ]);
        }
    }
 
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use App\Mail\OTPMail;
use App\Mail\PasswordEmail;
use App\Notifications\UserLoginNotification;
use App\Jobs\SendPasswordEmail;
use App\Jobs\SendSupportEmail;
use App\Events\UserLoggedIn;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // If validation fails, return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Get the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if the user's status is inactive
        if ($user->status === 'inactive') {
            return response()->json(['message' => 'User is inactive.'], 403);
        }

        // Check if the user's login_attempts exceed 3
        if ($user->login_attempts >= 3) {
            // Set user status to inactive
            $user->status = 'inactive';
            // Reset login attempts
            $user->login_attempts = 0;
            $user->save();
            return response()->json(['message' => 'User account has been inactivated.'], 403);
        }

        // Attempt to log in the user
        $credentials = $request->only('email', 'password');
        $credentials['status'] = 'active';
        if (Auth::attempt($credentials)) {
            // Authentication successful, reset login_attempts
            $user->login_attempts = 0;
            $user->save();

            $accessToken = $user->createToken('Api-Access')->accessToken;

            // Generate and send OTP code via email
            // $otpCode = $this->generateOTPCode();
            // $this->sendOTPEmail($user, $otpCode);

            // Store the OTP code in a separate table
            // $expiresAt = now()->addMinutes(10);
            // OtpCode::create([
            //     'user_id' => $user->id,
            //     'otp_code' => $otpCode,
            //     'expires_at' => $expiresAt,
            // ]);


            // Send login notification
            // Dispatch the UserLoggedIn event
            // event(new UserLoggedIn($user));

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'Logged in successfully',
                'token' => $accessToken,
                'user' => $user,
            ], 200);
        } else {
            // Authentication failed, increment login_attempts
            $user->login_attempts++;
            $user->save();
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }


    // public function verifyOTP(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'otp_code' => 'required|string',
    //         'email' => 'required|email',
    //     ]);

    //     if ($validator->fails()) {
    //         return validationErrorResponse($validator->errors());
    //     }

    //     $email = $request->input('email');
    //     $user = User::where('email', $email)->first();

    //     if (!$user) {
    //         return serverErrorResponse('User not found', null, 404);
    //     }

    //     $otpCode = OtpCode::where('user_id', $user->id)
    //         ->where('otp_code', $request->otp_code)
    //         ->where('expires_at', '>', now())
    //         ->first();

    //     if (!$otpCode) {
    //         return validationErrorResponse(['otp_code' => ['Invalid or expired OTP code']]);
    //     }

    //     // OTP code is valid, grant full access
    //     $otpCode->delete();
    //     // Generate access token
    //     $accessToken = $user->createToken('Api-Access')->accessToken;

    //     return successResponse('OTP verification successful', ['token' => $accessToken, 'user' => $user]);
    // }
































    public function signup(Request $request)
    {
        try {

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'username' => 'required|string',
                'phone' => 'string',
                'position' => 'string',
                'email' => 'required|email|unique:users,email',
                'building_id' => 'nullable|exists:buildings,id',
                'floor_id' => 'nullable|exists:floors,id',
                'room_id' => 'nullable|exists:rooms,id',
                'role' => 'required|exists:roles,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            // Generate a random password using a custom function
            $password = $this->generatePassword(8);

            $authUser = auth()->user();

            // Create a new user record
            $user = new User();
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = Hash::make($password);
            $user->phone = $request->input('phone');
            $user->position = $request->input('position');
            $user->building_id = $request->input('building_id');
            $user->floor_id = $request->input('floor_id');
            $user->room_id = $request->input('room_id');
            $user->role_id = $request->input('role');
            $user->facility_id = $authUser->facility_id;
            $user->branch_id = $authUser->branch_id;
            $user->save();



            // Send the password to the user's email
            try {
                $this->sendPasswordEmail($user, $password);
                $emailSent = true;
                $message = 'User registered successfully';
            } catch (\Exception $e) {
                $emailSent = false;
                $message = 'User registered successfully, but failed to send password email';
                Log::error('Failed to send password email: ' . $e->getMessage());
            }

            $responseData = [
                'user' => $user,
                'email_sent' => $emailSent,
            ];

            return successResponse($message, $responseData, $emailSent ? 201 : 200);
        } catch (\Exception $e) {
            return serverErrorResponse('Failed to register user', $e->getMessage());
        }
    }

    private function generatePassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $password .= $characters[$index];
        }

        return $password;
    }

    // end of the function
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return successResponse('Logout successful');
    }




    public function profileChange(Request $request)
    {
        // Retrieve the authenticated user
        $user = $request->user();

        // Validate incoming request data for profile update
        $validator = Validator::make($request->all(), [
            'firstname' => 'string',
            'lastname' => 'string',
            'username' => 'string',
            'phone' => 'string',
            'position' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'string|confirmed|min:6',
        ]);

        // If validation fails, return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        // Update user's profile information
        if ($request->has('firstname')) {
            $user->firstname = $request->input('firstname');
        }

        if ($request->has('lastname')) {
            $user->lastname = $request->input('lastname');
        }


        if ($request->has('username')) {
            $user->username = $request->input('username');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('position')) {
            $user->position = $request->input('position');
        }

        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Save the updated profile information
        $user->save();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Profile changed successfully']);
    }


    // private function sendPasswordEmail(User $user, $password)
    // {
    //     $emailData = [
    //         'user' => $user,
    //         'password' => $password,
    //     ];

    //     Mail::send('emails.password', $emailData, function ($message) use ($user) {
    //         $message->to($user->email)
    //             ->subject('Your Account Password');
    //     });
    // }




    private function sendPasswordEmail(User $user, $password)
    {
        dispatch(new SendPasswordEmail($user, $password));
    }


    private function generateOTPCode()
    {

        return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    private function sendOTPEmail($user, $otpCode)
    {

        Mail::to($user->email)->send(new OTPMail($otpCode, $user));
    }



    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'message' => 'required',
            'name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return validationErrorResponse($validator->errors());
        }

        $name = $request->input('name', 'Anonymous');
        $email = $request->input('email');
        $message = $request->input('message');

        try {
            SendSupportEmail::dispatch($name, $email, $message);
        } catch (\Exception $e) {
            return serverErrorResponse('Failed to process support request', $e->getMessage());
        }

        return successResponse('Your message has been sent. We\'ll get back to you soon!');
    }
}

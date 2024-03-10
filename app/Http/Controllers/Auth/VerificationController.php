<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    public function verify(Request $request, $token)
    {
        // Find the user by verification token. You may also consider adding expiration logic for tokens.
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            Log::warning('Verification attempt with invalid token.', ['token' => $token]);
            return redirect('/login')->with('error', 'The verification link is invalid or expired.');
        }

        if ($user->email_verified_at) {
            Log::info('Email already verified.', ['user_id' => $user->id]);
            return redirect('/login')->with('info', 'Your email is already verified.');
        }

        // Perform the email verification
        $user->email_verified_at = now();
        $user->verification_token = null; // Optionally clear the token
        $user->save();

        Log::info('User email verified successfully.', ['user_id' => $user->id]);
        
        // Redirect the user with a success message.
        return redirect('/')->with('verified', true)->with('success', 'Your email has been successfully verified.');
    }
}

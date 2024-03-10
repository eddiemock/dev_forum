<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($token)
{
    $user = User::where('verification_token', $token)->firstOrFail();

    $user->email_verified_at = now();
    $user->verification_token = null; // Clear the token
    $user->save();

    // Redirect or inform the user their email is verified.
}
}

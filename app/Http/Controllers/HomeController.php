<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Discussion;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\SupportGroup;
use App\Models\Role;


class HomeController extends Controller
{
    public function index()
{
    $categories = Category::all(); // Existing code
    $supportGroups = SupportGroup::orderBy('scheduled_at', 'desc')->get(); // Fetch support groups

    return view('pages.index', compact('categories', 'supportGroups'));
}

    public function login()
    {
        // Show the login form
        return view('auth.login');
    }

    public function confirm_login(Request $request)
    {
        // Log that we've entered the method
        Log::info('Attempting to login', ['email' => $request->email]);
    
        // Prepare credentials
        $credentials = $request->only('email', 'password');
    
        // Attempt to authenticate without directly logging in
        if (Auth::validate($credentials)) {
            $user = Auth::getLastAttempted();
    
            // Check if the user's email is verified
            if ($user->email_verified_at !== null) {
                // Log successful authentication
                Log::info('Authentication successful', ['email' => $request->email]);
    
                // Manually log in the user
                Auth::login($user, $request->filled('remember'));
    
                // Regenerate the session to protect against session fixation attacks
                $request->session()->regenerate();
    
                // Redirect to intended page or default to dashboard
                return redirect()->intended('/');
            } else {
                // Log failed authentication attempt due to unverified email
                Log::warning('Authentication failed - email not verified', ['email' => $request->email]);
    
                // Redirect back with error
                return back()->withErrors([
                    'email' => 'You need to verify your email address before you can log in.',
                ]);
            }
        }
    
        // Log failed authentication attempt
        Log::warning('Authentication failed', ['email' => $request->email]);
    
        // Redirect back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register()
    {
        // Show the registration form
        return view('auth.register');
    }

    public function register_confirm(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'country' => ['required', 'string', 'max:255'],
    ]);

    
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'country' => $validatedData['country'],
        'verification_token' => Str::random(60),
    ]);
    

    // Assign the 'user' role to the new user
    $userRole = Role::where('name', 'user')->first();
    if ($userRole) {
        $user->role()->associate($userRole);
        $user->save();
    }

    try {
        Mail::to($user->email)->send(new VerifyEmail($user));
        Log::info('Verification email sent', ['user_id' => $user->id]);
    } catch (\Exception $e) {
        Log::error('Failed to send verification email', ['error' => $e->getMessage()]);
    }
    
    


    // Redirect to a specific route after registration
    return redirect('/');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        $discussions = Discussion::all(); // Fetch all discussions. Adjust the query as needed.
    
        return view('pages.dashboard', compact('discussions'));
    }
}
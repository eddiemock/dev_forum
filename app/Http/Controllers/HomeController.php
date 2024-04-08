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
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
class HomeController extends Controller
{
    public function index()
{
    $user = auth()->user(); 
    $categories = Category::all();
    $supportGroups = SupportGroup::orderBy('scheduled_at', 'desc')->paginate(10); // Fetch support groups with pagination
    $appointments = $user->appointments()->with('professional')->get();
    return view('pages.index', compact('categories', 'supportGroups', 'appointments'));
}

    public function login()
    {
        // Show the login form
        return view('auth.login');
    }

    public function confirm_login(Request $request)
{
    // Log the attempt to login
    Log::info('Attempting to login', ['name' => $request->input('name')]);

    // Prepare credentials using name
    $credentials = ['name' => $request->input('name'), 'password' => $request->input('password')];

    // Attempt to authenticate without directly logging in
    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $user = Auth::user();

        // Check if the user's email is verified
        if ($user->email_verified_at !== null) {

            // Check for a recent password reset request before logging the user in
            $tokenExists = DB::table('password_resets')->where('email', $user->email)
                            ->where('created_at', '>=', now()->subHours(24))->exists();

            if ($tokenExists) {
                // Inform the user about the pending password reset request
                return back()->withErrors([
                    'name' => 'A password reset request is pending. Please check your email or wait 24 hours to request a new link.',
                ]);
            }

            // Log successful authentication
            Log::info('Authentication successful', ['name' => $request->input('name')]);

            // Regenerate the session to protect against session fixation attacks
            $request->session()->regenerate();

            // Redirect to intended page or default to dashboard
            return redirect()->intended('/');
        } else {
            // Log failed authentication attempt due to unverified email
            Log::warning('Authentication failed - email not verified', ['name' => $request->input('name')]);

            // Redirect back with error
            return back()->withErrors([
                'name' => 'You need to verify your email address before you can log in.',
            ]);
        }
    } else {
        // Log failed authentication attempt
        Log::warning('Authentication failed', ['name' => $request->input('name')]);

        // Redirect back with error
        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }
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
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Discussion;
class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Fetch all categories from the database
        return view('pages.index', compact('categories')); // Pass categories to the view
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
    
    // Attempt to authenticate
    if (Auth::attempt($credentials)) {
        // Log successful authentication
        Log::info('Authentication successful', ['email' => $request->email]);

        // Regenerate the session to protect against session fixation attacks
        $request->session()->regenerate();

        // Redirect to intended page or default to dashboard
        return redirect()->intended('dashboard');
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
    'name' => $validatedData['name'], // Change this to 'name' to match your database column
    'email' => $validatedData['email'],
    'password' => Hash::make($validatedData['password']), // Hash the password
    'country' => $validatedData['country'],
]);


    // Optionally log the user in
    Auth::login($user);

    // Redirect to a specific route after registration
    return redirect()->route('index'); // Make sure 'index' is a defined route in your web.php
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index(){
        // show all posts by a user
        // $user = User::where('id', 1)->first();
        // return dd($user->discussions);
    

        $discussions = Discussion::orderBy('created_at','desc')->paginate(20);

        return view('pages.index', compact('discussions'));
    }

    public function login(){
        return view('pages.login');
     }
    public function confirm_login(Request $request){
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $email = $request->input('email');
        $password =$request->input('password');
        $user = User::where([
            'email'=> $email,
            'password' =>$password
        ])->first();

        // return dd($request);

        if ($user){
            $message = "You have successfully logged in";
            $request->session()->put(
                [
                    'name'=> $user->name,
                    'id'=> $user->id,
                   
                ]
            );
            return redirect('/')->with('success', $message);
        }
        else{
            $message = "Invalid credentials";
            return back()->with('error', $message);
            // return view('pages.login',compact('message'));
        }

    }

    public function register(){
        return view('pages.register');
    }

    public function register_confirm(Request $request){
        $validated_data = $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'confirm_password' => 'required',
            'country' => 'required'
        ]);

        $password = $request->input('password');
        $confirm_password= $request->input('confirm_password');
        if ($password != $confirm_password){
            $message = "Passwords do no match";
            return back()->with('error', $message);
        }

        $user = new User;
        $user->name =$request->input('name');
        $user->email =$request->input('email');
        $user->country =$request->input('country');
        $user->password =$request->input('password');
        $user->save();

        $message = "You have successfully registered yourself";
        
        return redirect('/login')->with('success', $message); 

    }
    public function logout() {
        session()->flush();
        $message = "Logged Out";
        return redirect('/login')->with('success', $message);
    }
}

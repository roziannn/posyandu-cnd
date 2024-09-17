<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('content.authentications.auth-register-basic',[
            'title' => 'Register-Basic'
        ]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        // Hash the password before storing it
        $validateData['password'] = Hash::make($validateData['password']);

        // Create the user
        User::create($validateData);

        // Flash a success message to the session
        $request->session()->flash('success', 'Registration successful! Please login.');

        // Redirect to the login page
        return redirect('/login');
    }
}
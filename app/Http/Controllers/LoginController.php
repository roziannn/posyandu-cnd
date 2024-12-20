<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

  public function index()
  {
    return view('content.authentications.auth-login-basic', [
      'title' => 'Login-Basic'
    ]);
  }
  public function authenticate(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email:dns',
      'password' => 'required'
    ]);

    // if(Auth::attempt($credentials)){
    //     $request->session()->regenerate();
    //     return redirect()->intended('/dashboard');
    // }

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      $user = Auth::user();

      if ($user->role === 'ortu') {
        return redirect()->intended('/dashboard/ortu');
      } elseif ($user->role === 'petugas') {
        return redirect()->intended('/dashboard/petugas');
      } elseif ($user->role === 'kades') {
        return redirect()->intended('/dashboard/kades');
      }

      return redirect()->intended('/dashboard');
    }
    return back()->with('loginError', 'Login failed!');
  }
  public function logout(Request $request)
  {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
  }
  protected function redirectTo()
  {
    return '/dashboard';
  }
}

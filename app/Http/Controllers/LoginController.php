<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function index() 
    {
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // using bcrypt
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            // Mengambil pengguna yang saat ini masuk
            $user = Auth::user();

            // Memeriksa apakah pengguna adalah admin
            if ($user->is_admin == 1) {
                return redirect()->intended('/dashboard'); // Pengguna adalah admin
            } else {
                return redirect()->intended('/dashboard'); // Pengguna bukan admin
            }
        }

        return back()->with('loginError', 'Login Failed.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}

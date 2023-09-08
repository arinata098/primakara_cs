<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    public function edit()
    {
            return view('password.index');
    }

    public function update()
    {
        request()->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        $currentPassword = auth()->user()->password;
        $old_password = request('old_password');
        $old_password = hash('sha512', $old_password);

        // dd($new_password);
        if($old_password === $currentPassword) {
            auth()->user()->update([
                'password' => hash('sha512', request('password')),
            ]);
            return redirect()->back()->with('success', "Password Berhasil diganti");
        }else{
            return redirect()->back()->with('error', 'Password lama yang anda masukan salah!');
        }
    }
}

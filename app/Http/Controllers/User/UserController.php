<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        // dd("Berhasil login");
            return view('user.index', [
                'title' => 'Dashboard',
                'secction' => 'Dashboard',
                'active' => 'Dashboard'
            ]);
    }
}

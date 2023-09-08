<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    public function index()
    {
        // dd("Berhasil login");    
            return view('dashboard.index', [
                'title' => 'Dashboard',
                'secction' => 'Dashboard',
                'active' => 'Dashboard'
            ]);
    }
}

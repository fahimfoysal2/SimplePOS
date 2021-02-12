<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        if (Auth::id() != 1) {
////            throw new \Exception('Only Admin access');
//            echo 'Only Admin access';
//            exit();
//        }

    }

    public function manageRoles()
    {
        return view('admin/roles');
    }

    public function manageUsers()
    {
        return view('admin/users');
    }
}

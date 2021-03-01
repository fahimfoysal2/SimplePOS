<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $role = User::find(Auth::id())->role;
        $user_level = $role->role_level;
//        {{ !empty($user->role) ? $user->role->name:'' }};

        switch ($user_level) {
            case 3:
                return view('admin/admin', compact('user_level'));

            case 2:
                return view('manager/manager', compact('user_level'));

            case 1:
                return view('seller/seller', compact('user_level'));

            default:
                return view('home', compact('user_level'));
        }
    }
}

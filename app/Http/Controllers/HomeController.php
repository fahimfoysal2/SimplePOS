<?php

namespace App\Http\Controllers;

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
        $user_level = Auth::id();

        switch ($user_level) {
            case 1:
                return view('admin/admin', compact('user_level'));

            case 2:
                return view('manager/manager', compact('user_level'));

            case 3:
                return view('seller/seller', compact('user_level'));

            default:
                return view('home', compact('user_level'));
        }
    }
}

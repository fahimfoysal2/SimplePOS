<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
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
//        dd($role);
        $user_level = !empty($role->role_level) ? $role->role_level : '0';

        $report = $this->generateSales();

        switch ($user_level) {
            case 3:
                return view('admin/admin', compact('user_level', "report"));

            case 2:
                return view('manager/manager', compact('user_level', "report"));

            case 1:
                return view('seller/seller', compact('user_level', "report"));

            default:
                return view('home', compact('user_level'));
        }
    }

    public function generateSales()
    {
        $sales_today = Sale::whereDate('created_at', Carbon::today())->get();

        $report['total_sales'] = $sales_today->sum('amount');
        $report['orders'] = $sales_today->count('id');

        $products = Product::all();

        $report['total_product'] = $products->count('isbn');
        $report['total_items'] = $products->sum('inventory_size');

        return $report;

    }
}

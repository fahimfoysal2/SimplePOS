<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('sells.sell_page');
    }

    public function findProduct(Request $request)
    {
        if ($request->ajax()) {

            $product = Product::query()
                ->where('name', 'LIKE', "%{$request->key}%")
                ->orWhere('isbn', 'LIKE', "%{$request->key}%")
                ->where('item_status', '=', 'Active')
                ->get(['id', 'name', 'selling_price', 'inventory_size' ]);

            if (sizeof($product) == 0){
                $product[] = 0;
            }

            return response()->json($product);
        }
    }
}

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

    /**
     * search product
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findProduct(Request $request)
    {
        if ($request->ajax()) {

            $product = Product::query()
                ->where('name', 'LIKE', "%{$request->key}%")
                ->orWhere('isbn', 'LIKE', "%{$request->key}%")
                ->where('item_status', '=', 'Active')
                ->get(['id', 'name', 'selling_price', 'inventory_size']);

            if (sizeof($product) == 0) {
                $product[] = 0;
            }

            return response()->json($product);
        }
    }


    public function getOneProduct(Request $request)
    {
        $product = Product::find($request->key);

        return response()->json($product);
    }


    /**
     * complete sell
     */
    public function completeSell(Request $request)
    {
        print_r($request->all());

        $user_name = $request->sell_info['customer_name'];
        $user_phone = $request->sell_info['customer_name'];

//       make sell id

        $all_products = $request->sell_info['products'];

        $new_list = [];
//        ---------------
        $serialize = array_map("serialize", $all_products);
        $count     = array_count_values ($serialize);
        $unique_product    = array_unique($serialize);

        foreach($unique_product as &$u)
        {
            $u_count = $count[$u];
            $u = unserialize($u);
            $u['quantity'] = $u_count;
        }

        print_r($unique_product);
//        -------------------
        foreach ($unique_product as $product){
            $id = $product['id'];
            $quantity = $product['quantity'];

//            cost calculation
//            deduct from db

            echo $id.' '.$quantity."--";
        }

        return response()->json();
    }
}

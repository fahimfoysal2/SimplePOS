<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = User::find(Auth::id())->role;
        $user_level =  !empty($role->role_level) ? $role->role_level:'0' ;

        if ($user_level < 2){
            return  abort(403);
        }

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
//        print_r($request->all());

        // --------------------
        $user_name = isset($request->sell_info['customer_name']) ? $request->sell_info['customer_name']:"Anonymus";
        $user_phone = isset($request->sell_info['customer_mobile'])? $request->sell_info['customer_mobile']:"Anonymus";
        $amount = 0;
        // ---------------------

//       make sell id



        $all_products = $request->sell_info['products'];



        $new_list = [];
        // ---------------------
        $serialize = array_map("serialize", $all_products);
        $count     = array_count_values ($serialize);
        $unique_product    = array_unique($serialize);

        foreach($unique_product as &$u)
        {
            $u_count = $count[$u];
            $u = unserialize($u);
            $u['quantity'] = $u_count;
        }

        //  -------------------
        //  print_r($unique_product);
        //  -------------------
        foreach ($unique_product as $product){
            $id = $product['id'];
            $quantity = $product['quantity'];

            //---------- cost calculation -----------
            $amount += $quantity *  $product['price'];
            //---------- deduct from db -------------

        }


        // -------------- make sale ------------
        $sale_id = $this->make_sale($user_name, $user_phone, $amount);



        return response()->json($sale_id);
    }


    /**
     * store sale info into sales
     *
     * @param $user
     * @param $phone
     * @param $amount
     */
    public function make_sale($user, $phone, $amount)
    {
        $seller = Auth::id();

        $sale_id = Sale::create([
            'seller_id'  => $seller,
            'buyer_name' => $user,
            'buyer_phone'=> $phone,
            'amount'     => $amount,
        ]);

        return $sale_id->id;
    }
}

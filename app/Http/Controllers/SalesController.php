<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SoldProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = User::find(Auth::id())->role;
        $user_level = !empty($role->role_level) ? $role->role_level : '0';

        if ($user_level < 1) {
            return abort(403);
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
                ->where('name', 'LIKE', "%" . $request->key . "%")
                ->orWhere('isbn', 'LIKE', "%" . $request->key . "%")
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
        // --- user & amount --
        $user_name = isset($request->sell_info['customer_name']) ? $request->sell_info['customer_name'] : "Anonymus";
        $user_phone = isset($request->sell_info['customer_mobile']) ? $request->sell_info['customer_mobile'] : "Anonymus";
        $amount = 0;
        // ---------------------


        $all_products = $request->sell_info['products'];


        // --------------------------------
        // --- make unique product list ---
        // --------------------------------
        $serialize = array_map("serialize", $all_products);
        $count = array_count_values($serialize);
        $unique_product = array_unique($serialize);

        foreach ($unique_product as &$u) {
            $u_count = $count[$u];
            $u = unserialize($u);
            $u['quantity'] = $u_count;
        }


        //  -------------------
        //  print_r($unique_product);
        //  -------------------
        foreach ($unique_product as $product) {
            $id = $product['id'];
            $quantity = $product['quantity'];

            //---------- cost calculation -----------
            $amount += $quantity * $product['price'];
        }


        // -------------- make sale ------------
        $sale_id = $this->make_sale($user_name, $user_phone, $amount);
        // --------- record sold items ---------
        $this->record_sold_items($unique_product, $sale_id);
        //---------- deduct from db -------------


        // --------- return response --------
        $response = [
            "sold" => true,
            "buyer" => $user_name,
            "phone" => $user_phone,
            "seller" => Auth::user()->name,
            "sale_id" => $sale_id,
            "items" => $unique_product,
            "amount" => $amount,
        ];

        return response()->json($response);
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
            'seller_id' => $seller,
            'buyer_name' => $user,
            'buyer_phone' => $phone,
            'amount' => $amount,
        ]);

        return $sale_id->id;
    }

    /**
     * record sold items
     */
    public function record_sold_items($products, $sale_id)
    {
        foreach ($products as $product) {
            /**
             * add to sold table
             */
            SoldProduct::create([
                'sale_id'    => $sale_id,
                'product_id' => $product['id'],
                'quantity'   => $product['quantity'],
            ]);


            /**
             * update sored item quantity
             */
            $this->updateInventory($product);
        }
    }


    /**
     * update inventory size
     */
    public function updateInventory($update)
    {
        /**
         * get current inventory size
         */
        $product = DB::table('products')
            ->select('inventory_size')
            ->where('id', '=', $update['id'])
            ->first();


        $new_size = $product->inventory_size - $update['quantity'];

        /**
         * update inventory to new size
         */
        Product::where('id', $update['id'])
            ->update(array('inventory_size' => $new_size));
    }
}

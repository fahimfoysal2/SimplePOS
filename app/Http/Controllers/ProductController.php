<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display Product manage page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = User::find(Auth::id())->role;
//        $user_level = $role->role_level;
        $user_level =  !empty($role->role_level) ? $role->role_level:'0' ;

        if ($user_level < 2){
            return  abort(403);
        }

        return view('product/manage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = $request->validate([
            "isbn" => "required| unique:products,isbn"
        ]);

//        dd($validation);

        $product_status = '';

        if ($request->product_status) {
            $product_status = "Active";
        } else {
            $product_status = "Paused";
        }

        $product = [
            "isbn" => $request->isbn,
            "name" => $request->product_name,
            "description" => $request->product_details,
            "item_status" => $product_status,
            "buying_price" => $request->buying_price,
            "selling_price" => $request->selling_price,
            "inventory_size" => $request->inventory,
        ];

//        dd($product);

        $status = Product::create($product);
        if ($status) {
            $message = "New Product Added!";
        } else {
            $message = "Failed to add product..";
        }

        session()->flash('status', $message);
        return redirect()->back();
    }

    /**
     * Display All resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit">&#128295;</a> <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete">&#10060;</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $product = Product::find($request->id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product_status = '';
        if ($request->update_product_status) {
            $product_status = "Active";
        } else {
            $product_status = "Paused";
        }



//        $updated = DB::table('products')
//        ->updateOrFail([
//            "isbn" => $request->isbn,
//            "name" => $request->product_name,
//            "description" => $request->product_details,
//            "item_status" => $product_status,
//            "buying_price" => $request->buying_price,
//            "selling_price" => $request->selling_price,
//            "inventory_size" => $request->inventory,
//
//        ])->where('id', $request->product-id-to-update);

        $product = Product::find($request->product_id_to_update);

        $updated = $product->fill([
            "isbn" => $request->isbn,
            "name" => $request->product_name,
            "description" => $request->product_details,
            "item_status" => $product_status,
            "buying_price" => $request->buying_price,
            "selling_price" => $request->selling_price,
            "inventory_size" => $request->inventory,

        ])->save();


        return response()->json($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::find($request->id);

        if ($product) {
            $product->delete();
            return response()->json("Deleted");
        }else{
            return response()->json("Not Found");
        }
    }
}

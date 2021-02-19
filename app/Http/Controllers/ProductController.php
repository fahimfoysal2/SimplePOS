<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
            $product_status = 1;
        } else {
            $product_status = 0;
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
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

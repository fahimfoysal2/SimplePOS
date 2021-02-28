@extends('layouts.app')

@section('menu')

    @include('admin/menu')

@endsection


@section('content')
    <div class="card">
        <div class="card-header">{{ __('Seller Panel') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif


            <div class="row">
                <div class="col-md-5">
                    <div class="left-wrap">

                        <div class="user_detail border rounded">
                            {{--------user details form -------}}
                            <div class="user-wrap p-2 ">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">🧔</span>
                                    </div>
                                    <input type="text" required class="form-control" placeholder="Customer Name"
                                           aria-label="customer_name"
                                           aria-describedby="customer_name">
                                </div>

                                <div class="input-group mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">📱 &nbsp;</span>
                                    </div>
                                    <input type="text" required class="form-control" placeholder="Mobile No."
                                           aria-label="customer_phone"
                                           aria-describedby="customer_phone">
                                </div>
                            </div>
                        </div>
                        {{--   user form end --}}

                        {{-- ------------ product search box --}}
                        <div class="search-wrap border rounded my-3">
                            <div class="search p-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="addon-wrapping">🔎</span>
                                    </div>
                                    <input type="search" class="form-control" placeholder="Search Product"
                                           id="search_product"
                                           aria-label="product"
                                           aria-describedby="addon-wrapping">
                                </div>
                            </div>

                            <ul class="list-group found_products">

                            </ul>
                        </div>
                        {{--   ------------- search end --}}


                        <div class="sell_action mt-3 text-center">
                            <button class="btn btn-danger">Cancel</button>
                            <button class="btn btn-success">Complete</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="invoice border rounded h-100">
                        {{-------- Product invoice table ------------}}

                        <table class="table table-responsive-sm" id="product_table">
                            <thead class="thead-light">
                            <tr>

                                <th scope="col">Product Title</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td class="product_title">Pen</td>
                                <td class="quantity">5</td>
                                <td class="price">25</td>
                            </tr>
                            <tr>

                                <td class="product_title">a very long text in product name</td>
                                <td class="quantity">10</td>
                                <td class="price">100</td>
                            </tr>
                            <tr>

                                <td class="product_title">Larry</td>
                                <td class="quantity">3</td>
                                <td class="price">27</td>
                            </tr>
                            <tr>

                                <td class="product_title">Larry</td>
                                <td class="quantity">3</td>
                                <td class="price">27</td>
                            </tr>
                            <tr>

                                <td class="product_title">Larry</td>
                                <td class="quantity">3</td>
                                <td class="price">27</td>
                            </tr>
                            <tr>
                                <td class="product_title">Larry</td>
                                <td class="quantity">3</td>
                                <td class="price">27</td>
                            </tr>


                            </tbody>
                        </table>

                        {{------- Product Table ----------}}

                        <div class="total_price bg-info">
                            <div class="row">

                                <div class="col-8 total-wrap w-75">
                                    <h2>Total</h2>
                                </div>
                                <div class="col-4 total_amount">
                                    <h4 class="pr-2">1000</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function () {
            // delay function
            function throttle(f, delay) {
                var timer = null;
                return function () {
                    var context = this, args = arguments;
                    clearTimeout(timer);
                    timer = window.setTimeout(function () {
                            f.apply(context, args);
                        },
                        delay || 1000);
                };
            }

            // search in database after 1 sec of input
            $("#search_product").on('keyup', throttle(function () {
                var _inp = $(this).val();
                if (_inp.length >= 3) {
                    // console.log(_inp);
                    $.ajax({
                        url: "{{route('product.find')}}",
                        method: 'GET',
                        data: {key: _inp},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            $(".found_products").empty();
                            if (data[0] == 0) {
                                $(".found_products").append(
                                    "<li class='list-group-item'>" +
                                    "Not found!"
                                    + "</li>"
                                );
                            } else {
                                $.each(data, function (id, product) {
                                    $(".found_products").append(
                                        "<li class='list-group-item'>" +
                                        product.name +
                                        "<span class='ml-1 badge badge-primary'>" +
                                        product.inventory_size
                                        + "</span>" +
                                        "<span class='float-right add_cart'><button onclick='addToCart()'> ➕</button></span>"
                                        + "</li>"
                                    );
                                });
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                } else {
                    $(".found_products").empty();
                    return 0;
                }
            }));

            $("#search_product").on('keyup', function () {
                if (!$(this).val()) {
                    $(".found_products").empty();
                }
            });
        });

        // add product to list from search
        function addToCart(){
            console.log("xxxx");
            $("#product_table").append(
                `<tr>
                        <td class="product_title">q</td>
                        <td class="quantity">w</td>
                        <td class="price">e</td>
                    </tr>`
            );
        }
    </script>
@endsection

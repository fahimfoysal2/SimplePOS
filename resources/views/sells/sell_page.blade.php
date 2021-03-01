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
                                           aria-describedby="customer_name"
                                           id="customer_name">
                                </div>

                                <div class="input-group mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">📱 &nbsp;</span>
                                    </div>
                                    <input type="text" required class="form-control" placeholder="Mobile No."
                                           aria-label="customer_phone"
                                           aria-describedby="customer_phone"
                                           id="customer_mobile">
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
                            <button class="btn btn-danger" onclick="cancelSell()">Cancel</button>
                            <button class="btn btn-success" id="complete_sell">Complete</button>
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
                            {{-- row from ui--}}
                            </tbody>
                        </table>

                        {{------- Product Table ----------}}

                        <div class="total_price bg-info">
                            <div class="row">

                                <div class="col-8 total-wrap w-75">
                                    <h2>Total</h2>
                                </div>
                                <div class="col-4 total_amount">
                                    <h4 class="pr-2" id="total_amount">0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <form id="submit_purchase" action="{{route("sell.complete")}}" method="POST">
        @csrf
        <input type="hidden" name="sell_data" id="sell_data" value="dddd">
    </form>

@endsection

@section('page-script')
    <script>
        // sell information
        var sell_info = {};

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
                                    // console.log(product);
                                    $(".found_products").append(
                                        "<li class='list-group-item'>" +
                                        product.name +
                                        "<span class='ml-1 badge badge-primary'>" +
                                        product.inventory_size
                                        + "</span>" +
                                        "<span class='float-right add_cart'><button onclick='addToCart(\"" + product.id + "\")'> ➕</button></span>"
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


            //    add customer info to list
            $("#customer_name").on('keyup', throttle(function () {
                sell_info.customer_name = $(this).val();
                // console.log(sell_info);
            }));

            $("#customer_mobile").on('keyup', throttle(function () {
                sell_info.customer_mobile = $(this).val();
                // console.log(sell_info);
            }));


            // ------------- complete sell

            $("#complete_sell").on('click', function () {
                // var input = $("<input>")
                //     .attr("type", "hidden")
                //     .attr("name", "mydata").val(sell_info);
                // $('#submit_purchase').append(input);

                // $("#submit_purchase").submit();
                $.ajax({
                    url: "{{route('sell.complete')}}",
                    method: 'get',
                    data: {sell_info},
                    dataType: 'json',
                    success: function (data) {
                        alert("Purchase Complete");
                        location.reload();

                        // console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        });

        // product store to list
        sell_info.products = [];

        // add product to list from search
        function addToCart(id) {
            $.ajax({
                url: "{{route('tocart')}}",
                method: 'GET',
                data: {key: id},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    sell_info.products.push({id: data.id, quantity: 1});

                    $("#product_table").append(
                        `<tr><td class="product_title"><span class="remove_item"></span>` + data.name + `</td>
                        <td class="quantity"><input type="number" readonly class="quantity" value="1" "></td>
                        <td class="price">` + data.selling_price + `</td></tr>`
                    );

                    current_total = Number($("#total_amount").html());
                    current_total += data.selling_price;
                    $("#total_amount").html(current_total);
                },
                error: function (data) {
                    console.log(data);
                }
            })
            // console.log(id);
        }

        function cancelSell() {
            $("#product_table> tbody").empty();
            $("#total_amount").html('0.00');
            $("#customer_name, #customer_mobile").val(" ");
            sell_info = {};
        }
    </script>
@endsection

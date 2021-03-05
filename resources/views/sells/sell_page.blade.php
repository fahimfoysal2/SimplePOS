@extends('layouts.app')

@section('menu')

    @include('admin/menu')

@endsection


@section('content')

    {{-------  sales modal ------  --}}
    <!-- Modal -->
    <div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saleModalLabel">Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{--                    --}}
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h2>Invoice</h2>
                                    <h3 class="pull-right">Order # <span id="order_id">12345</span></h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-4">
                                        <address>
                                            <strong>Billed To:</strong><br>
                                            <span id="buyer_name">Buyer</span> <br>
                                            <span id="buyer_phone">Phone</span>
                                        </address>
                                    </div>
                                    <div class="col-4 text-right">
                                        <address>
                                            <strong>Seller:</strong><br>
                                            <span id="seller_name">Seller</span>
                                        </address>
                                    </div>
                                    <div class="col-4 text-right">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            {{date("F j, Y, g:i a")}}
                                            <br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table id="invoice_table" class="table table-condensed">
                                                <thead>
                                                <tr>
                                                    <td><strong>Item U. ID</strong></td>
                                                    <td class="text-center"><strong>Quantity</strong></td>
                                                    <td class="text-center"><strong>Price</strong></td>
                                                    {{--                                                    <td class="text-right"><strong>Totals</strong></td>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{-- from jquery sell dta--}}

                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    {{--                                                    <td class="thick-line"></td>--}}
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                                    <td class="thick-line text-center" id="invoice_total_amount">00.00</td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                    --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
        </div>
    </div>
    {{-------  sales modal ------  --}}



    <div class="card">
        <div class="card-header">{{ __('Seller Panel') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif


            <div class="row">
                <div class="col-12 col-md-5">
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
                            <button class="btn btn-danger" onclick="clearSell()">Cancel</button>
                            <button class="btn btn-success" id="complete_sell">Complete</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-7">
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


        <div id="wait" style="">
            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
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

        $(document).ajaxStart(function () {
            $("#wait").css("display", "block");
        });


        $(document).ajaxComplete(function () {
            $("#wait").css("display", "none");
        });


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


            // ------------- complete sell --------------

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
                        // alert("Purchase Complete");
                        // acation.reload();
                        $("#order_id").html(data.sale_id);
                        $("#buyer_name").html(data.buyer);
                        $("#buyer_phone").html(data.phone);
                        $("#seller_name").html(data.seller);
                        $("#invoice_total_amount").html(data.amount);

                        $.each(data.items, function (index, value) {
                            $('#invoice_table tbody').append(`<tr><td class="item_id">` + value.id + `</td>
<td class="text-center item_quantity">` + value.quantity + `</td>
<td class="text-center item_price">x` + value.price + `</td></tr>`);
                        });

                        clearSell();
                        $("#saleModal").modal('show');
                        // console.log(data);


                    },
                    error: function (data) {
                        console.log(data);
                        alert("Purchase Failed");
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
                    sell_info.products.push({id: data.id, quantity: 1, price: data.selling_price});

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

        function clearSell() {
            $("#product_table> tbody").empty();
            $("#total_amount").html('0.00');
            $("#customer_name, #customer_mobile").val(" ");
            sell_info.products = [];
            sell_info.customer_mobile = ' ';
            sell_info.customer_name = ' ';
        }
    </script>
@endsection

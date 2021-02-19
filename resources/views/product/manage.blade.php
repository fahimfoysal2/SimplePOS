@extends('layouts.app')

@section('menu')
    @include('admin/menu')
@endsection

@section('content')

    {{-- Modal --}}
    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog"
         aria-labelledby="addProductTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductTitle">Add new product to Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{--                modal body with form to submit  --}}
                <div class="modal-body">

                    <form id="add-item" method="POST" action="{{route('product.save')}}" autocomplete="off">
                        @csrf
                        <div class="form-group row">
                            <label for="isbn" class="col col-form-label">ISBN</label>
                            <div class="col-10">
                                <input type="text" required class="form-control" id="isbn" name="isbn"
                                       placeholder="ISBN / product Code" value="{{ old('isbn') }}">

                                @error('isbn')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="product_name" class="col col-form-label">Name</label>
                            <div class="col-10">
                                <input type="text" required placeholder="Product Name" class="form-control"
                                       id="product_name"
                                       name="product_name" autocomplete="off"
                                       value="{{ old('product_name') }}"
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_details" class="col col-form-label">Product Details</label>
                            <div class="col-10">
                                <textarea class="form-control" id="product_details" value="{{ old('product_details') }}"
                                          name="product_details"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_status" class="col col-form-label">Product Status</label>
                            <div class="col-10 custom-control custom-switch">
                                &nbsp;&nbsp;&nbsp;
                                <input type="checkbox" checked class="form-control custom-control-input"
                                       id="product_status" name="product_status">
                                <label class="custom-control-label" for="product_status">Set item active or
                                    inactive</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inventory" class="col col-form-label">Inventory Size</label>
                            <div class="col-9">
                                <input type="number" value="0" class="form-control"
                                       placeholder="Number of product to add"
                                       id="inventory" name="inventory">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="buying_price" class="col col-form-label">Buying Price</label>
                            <div class="col-9">
                                <input type="number" step="any" value="0" class="form-control"
                                       placeholder="Price to buy" id="buying_price"
                                       name="buying_price">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selling_price" class="col col-form-label">Selling Price</label>
                            <div class="col-9">
                                <input type="number" step="any" value="0" class="form-control"
                                       placeholder="Selling Price" id="selling_price"
                                       name="selling_price">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="add-item">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{--    modal end --}}


    {{--  main content card header  --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    {{ __('Inventory') }}
                </div>
                <div class="col text-right">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addProduct">
                        Add Product
                    </button>
                </div>
            </div>
        </div>


        <div class="card-body">

            {{--        if there are any session flush--}}
            @if (session('status'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {{-- if any error message in seeeion --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    Operation Failed. Reasons:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{--main content section --}}
            <div class="row">
                <div class="col">
                    <div class="table-wrapper">

                        <table class="table table-bordered product-datatable" id="data-table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>ISBN</th>
                                <th>Title</th>
                                <th>Item Status</th>
                                <th>Inventory</th>
                                <th>Buy Price</th>
                                <th>Sell Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('page-script')
    <link href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">
        $(function () {
            var table = $('.product-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('product.all') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'isbn', name: 'isbn'},
                    {data: 'name', name: 'name'},
                    {data: 'item_status', name: 'item_status'},
                    {data: 'inventory_size', name: 'inventory_size'},
                    {data: 'buying_price', name: 'buying_price'},
                    {data: 'selling_price', name: 'selling_price'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

    </script>
@endsection

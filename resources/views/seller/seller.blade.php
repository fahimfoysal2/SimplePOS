@extends('layouts.app')

@section('menu')

    @section('menu')

        @include('seller/menu')

    @endsection

@endsection
<!--left menu end-->





@section('content')
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

                {{-- Status Cards row --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                            <div class="card-header">Total Sell Today</div>
                            <div class="card-body">
                                <p class="card-title">
                                    <span class="text-primary">{{$report['orders'] ?? '0'}}</span> orders
                                </p>
                                {{--                {{dd($report)}}--}}
                                <p class="card-text">
                                    <span class="display-3">{{$report['total_sales'] ?? '0'}}</span> Taka
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                            <div class="card-header">Inventory</div>
                            <div class="card-body">
                                <p class="card-title">
                                    <span class="text-primary">{{$report['total_product'] ?? '0'}}</span> Products
                                </p>
                                <p class="card-text">
                                    <span class="display-3">{{$report['total_items'] ?? '0'}}</span> Items
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- status card row ends --}}
        </div>
    </div>
@endsection

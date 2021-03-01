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

            {{ __('As a Seller!') }}
        </div>
    </div>
@endsection

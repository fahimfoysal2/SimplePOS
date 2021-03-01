@extends('layouts.app')

@section('menu')

<div class="card">
    <div class="card-header">{{ __('Menu') }}</div>

    <div class="card-body">
        <ul class="list-group">

            <li class="list-group-item">
                <a href="/">Reports</a>
            </li>

            <li class="list-group-item">
                <a href="{{route('sell')}}">Sell</a>
            </li>

            <li class="list-group-item">
                <a href="{{route('product.manage')}}">Manage Products</a>
            </li>
        </ul>
    </div>
</div>
@endsection
<!--left menu end-->




{{-- main content --}}
@section('content')
<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>

    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        {{ __('As a Manager!') }}
    </div>
</div>
@endsection

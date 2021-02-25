@extends('layouts.app')

@section('menu')

<div class="card">
    <div class="card-header">{{ __('Menu') }}</div>

    <div class="card-body">
        {{ __('You are logged in!') }}
        <h6 class="text-danger">No Role Defined</h6>
    </div>
</div>
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

        {{ __('As a guest user!') }}
        <h3 class="text-info">Wait for Admin Approval.</h3>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('menu')

    @include('admin/menu')

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

        {{ __('As an Admin!') }}
    </div>
</div>
@endsection

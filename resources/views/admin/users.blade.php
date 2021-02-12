@extends('layouts.app')

@section('menu')

    @include('admin/menu')

@endsection
<!--left menu end-->


@section('content')
    <div class="card">
        <div class="card-header">{{ __('Manage Users') }}</div>

        <div class="card-body">
            {{ __('Manage Users') }}
        </div>
    </div>
@endsection

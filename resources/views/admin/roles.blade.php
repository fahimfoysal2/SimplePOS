@extends('layouts.app')

@section('menu')

    @include('admin/menu')

@endsection
<!--left menu end-->


@section('content')
    <div class="card">
        <div class="card-header">{{ __('Roles') }}</div>

        <div class="card-body">
            {{ __('Manage Roles') }}
        </div>
    </div>
@endsection

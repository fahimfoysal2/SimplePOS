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

{{--            <li class="list-group-item">--}}
{{--                <a href="{{route('manageRoles')}}">Manage Roles</a>--}}
{{--            </li>--}}

            <li class="list-group-item">
                <a href="{{route('manageUsers')}}">Manage Users</a>
            </li>

            <li class="list-group-item">
                <a href="{{route('product.manage')}}">Manage Products</a>
            </li>
        </ul>
    </div>
</div>

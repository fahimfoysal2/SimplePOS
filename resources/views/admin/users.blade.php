@extends('layouts.app')

@section('menu')

    @include('admin/menu')

@endsection
<!--left menu end-->


@section('content')
    <div class="card">
        <div class="card-header">{{ __('Manage Users') }}</div>

        {{-- Modal --}}
        <div class="modal fade" id="userUpdateModal"
             tabindex="-1" role="dialog" aria-labelledby="userUpdateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userUpdateModalLabel">Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" method="post" action="{{route('updateUser')}}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="user_id" name="user_id">
                            </div>
                            <div class="form-group">
                                <label for="user_name" class="col-form-label">User:</label>
                                <input type="text" class="form-control" id="user_name" name="user_name">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>


                            <div class="form-group">
                                <label for="role" id="role" class="col-form-label">Role:</label>
                                {{--<input type="role" class="form-control" id="role" name="role">--}}
                                <select name="role" class="form-select form-control" aria-label=".form-select-sm role">
                                    <option value="-1" selected>Open this select menu</option>
                                    <option value="1">Seller</option>
                                    <option value="2">Manager</option>
                                    <option value="3">Admin</option>
                                    <option value="0">Guest</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal end --}}

        <div class="card-body" style="overflow: auto">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Email</th>
                    <th scope="col">Manage</th>
                </tr>
                </thead>
                <tbody>

                {{--                                {{dd($users)}}--}}

                @foreach($users as $user)
                    <tr>
                        <td>
                            {{ $user->id }}
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{--if any of these users doesn't have role, it will throw error--}}
                            {{ !empty($user->role) ? $user->role->role_name:'Pending Approval' }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{--edit / delete--}}
                            <a class="edit-modal" id="u{{$user->id}}" data-u{{$user->id}}='{{$user}}'>&#128295;</a>
                            <a href="{{route('deleteUser', ['id'=>$user->id])}}">&#10060;</a>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $('.edit-modal').click(function (event) {
            event.preventDefault();
            var user = this.id;
            var userData = ($(this).data());
            var targetModal = $('#userUpdateModal');
            targetModal.find('.modal-body #user_id').val(userData[user].id);
            targetModal.find('.modal-body #user_name').val(userData[user].name);
            targetModal.find('.modal-body #email').val(userData[user].email);
            targetModal.modal('show');
        });
    </script>
@endsection


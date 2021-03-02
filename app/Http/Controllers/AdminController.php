<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        if (Auth::id() != 1) {
////            throw new \Exception('Only Admin access');
//            echo 'Only Admin access';
//            exit();
//        }

    }

    public function authorize_admin()
    {
        $role = User::find(Auth::id())->role;
        $user_level =  !empty($role->role_level) ? $role->role_level:'0' ;
//        $user_level = $role->role_level;

        if ($user_level == 3){
            return true;
        }

        return 0;
    }

    public function manageRoles()
    {
        return view('admin/roles');
    }

    public function manageUsers()
    {

        if (!$this->authorize_admin()){
            return abort(403);
        }

        $all_users = User::with('role')->get();

        return view('admin/users', ['users' => $all_users]);
    }

    public function deleteUser($id)
    {
        if (!$this->authorize_admin()){
            return abort(403);
        }

        $deleted = User::destroy($id);
        if ($deleted) {
            session()->flash('status', 'User Removed!');
        } else {
            session()->flash('status', 'Task Failed!');
        }

        return redirect()->back();
    }

    public function updateUser(Request $request)
    {
        if (!$this->authorize_admin()){
            return abort(403);
        }

        $user = $request->validate([
            'user_id' => 'required',
            'user_name' => 'required',
            'email' => 'required'
        ]);

        $data_to_update['name'] = $user['user_name'];
        $data_to_update['email'] = $user['email'];


        if (isset($request->password)) {
            $data_to_update['password'] = bcrypt($request->password);
        }

        // Update Or Create user role

        if (($request->role) != -1) {
            $role_name = ' ';

            if ($request->role == 1) {
                $role_name = "Seller";
            } else if ($request->role == 2) {
                $role_name = "Manager";
            } else if ($request->role == 3) {
                $role_name = "Admin";
            } else if ($request->role == 0) {
                $role_name = "Guest";
            } else {
// ---------------------make else rule
                return 0;
            }

            $role_set = Role::updateOrCreate(
                ['user_id' => $request->user_id],
                ['role_name' => $role_name, 'role_level' => $request->role]
            );

            if ($role_set) {
                session()->flash('status', 'Role Updated!');
            }

        }

        // ------ update user details
        $status = User::where('id', $request->user_id)
            ->update($data_to_update);

        if ($status) {
            session()->flash('status', 'User Updated!');
        } else {
            session()->flash('status', 'Task Failed!');
        }

        return redirect()->back();
    }

}

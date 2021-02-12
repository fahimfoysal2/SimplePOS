<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function manageRoles()
    {
        return view('admin/roles');
    }

    public function manageUsers()
    {
        $all_users = User::all();

        return view('admin/users', ['users' => $all_users]);
    }

    public function deleteUser($id)
    {
        $deleted = User::destroy($id);
        if ($deleted){
            session()->flash('status', 'User Removed!');
        }else{
            session()->flash('status', 'Task Failed!');
        }

        return redirect()->back();
    }

    public function updateUser(Request $request)
    {
        $user = $request->validate([
            'user_id' => 'required',
            'user_name' => 'required',
            'email' => 'required'
        ]) ;

        $data_to_update['name'] = $user['user_name'];
        $data_to_update['email'] = $user['email'];

        if (isset($request->password)){
            $data_to_update['password'] = $request->password;
        }

        $status = User::where('id', $request->user_id)
            ->update($data_to_update);

        if ($status){
            session()->flash('status', 'User Updated!');
        }else{
            session()->flash('status', 'Task Failed!');
        }

        return redirect()->back();
    }

}

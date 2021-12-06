<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Asset;
use App\Models\Department;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
    }

    public function getUsers()
    {
        $users = User::where('is_admin', 0)->orWhereNull('is_admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function addUser()
    {
        $departments = Department::get();
        return view('admin.users.add', compact('departments'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'department_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user_data = array(
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'password' => Hash::make($request->password),
        );

        User::create($user_data);

        Session::flash('success_message','Successfully saved');

        return redirect('admin/users');
    }

    public function editUser($id)
    {
        $user = User::where('id', $id)->where('is_admin', 0)->first();
        if (!$user) abort(404);
        $departments = Department::get();
        return view('admin.users.edit', compact('user', 'departments'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email,'.$id,
            'department_id' => ['required'],
        ]);
        if (isset($request->password) && !empty($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }

        $user_data = array(
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
        );
        if (isset($request->password) && !empty($request->password)) {
            $user_data['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($user_data);

        Session::flash('success_message','Successfully updated');

        return redirect('admin/users/edit/'.$id);
    }

    public function destroyUser($id)
    {
        $delete = User::where('id', $id)->delete();
        // Release assets under the user
        Asset::where('assigned_to', $id)->update(['assigned_to' => 0]);

        if ($delete) {
            Session::flash('success_message','Successfully deleted');
            echo "success";
        }
    }
}

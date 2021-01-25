<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function _construct()
    {
        $this->middleware('permission:read_users')->only('index');
        $this->middleware('permission:create_users')->only('create','store');
        $this->middleware('permission:update_users')->only(['edit','update']);
        $this->middleware('permission:delete_users')->only(['destroy']);

    }
    public function index(){
        $users = User::WhereRoleNot(['super_admin'])
        ->WherSearch(request()->search)
        ->with('roles')
        ->paginate(5);
        return view('dashboard.users.index',compact('users'));
    }
    public function create(){
        $roles = Role::WhereRoleNot(['super_admin','admin','user'])->get();
        return view('dashboard.users.create',compact('roles'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|confirmed',
            'role_id'=> 'required|numeric',
        ]);

        $request->merge(['password' => bcrypt($request->password)]);
       // dd($request->all());
        $user = User::create($request->all());
        $user->attachRoles(['admin',$request->role_id]);

        session()->flash('success','Data added successfully');
        return redirect()->route('dashboard.users.index');
    }

    public function show(){

    }

    public function edit(User $user){
        $roles = Role::WhereRoleNot(['super_admin','admin','user'])->get();
        return view('dashboard.users.edit',compact('user','roles'));
    }

    public function update(Request $request ,User $user){
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email,'.$user->id,
            'role_id'=> 'required|numeric',
        ]);

        $user->update($request->all());
        $user->syncRoles(['admin',$request->role_id]);

        session()->flash('success','Data updated successfully');
        return redirect()->route('dashboard.users.index');
    }

    public function destroy(User $user){
        $user->delete();
        session()->flash('success','Data deleted successfully');
        return redirect()->route('dashboard.users.index');
    }
}

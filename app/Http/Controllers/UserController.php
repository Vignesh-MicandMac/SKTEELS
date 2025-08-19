<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('masters.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('masters.users.create', compact('roles'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('masters.users.edit', compact('roles', 'user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'mobile' => 'nullable|string|max:10',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name' => 'Name field is required',
            'email' => 'Email field is required',
            'email.unique' => 'Email field should be unique',
            'password' => 'Password field is required min 6 values',
            'role_id' => 'Role field is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'role_id' => $request->role_id,
        ]);


        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6',
            'mobile' => 'nullable|string|max:10',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name' => 'Name field is required',
            'email' => 'Email field is required',
            'email.unique' => 'Email field should be unique',
            'password' => 'Password field is required min 6 values',
            'role_id' => 'Role field is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'role_id' => $request->role_id,
        ]);


        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Deleted successfully.');
    }
}

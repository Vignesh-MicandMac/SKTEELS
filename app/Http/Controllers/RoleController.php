<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('masters.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('masters.roles.create');
    }
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('masters.roles.edit', compact('role'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles|max:255',
        ], [
            'name.required' => 'Name field is required',
            'name.unique' => 'Name field should be unique',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        Role::create($request->only('name'));
        return redirect()->route('users.role.index')->with('success', 'Role created successfully.');
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles|max:255',
        ], [
            'name.required' => 'Name field is required',
            'name.unique' => 'Name field should be unique',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('users.role.index')->with('success', 'Role Updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->forceDelete();
        return redirect()->route('users.role.index')->with('success', 'Role deleted successfully.');
    }
}

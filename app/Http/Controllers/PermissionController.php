<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::whereNull('deleted_at')->get();
        $permissions = Permission::whereNull('deleted_at')->get();

        return view('masters.permissions.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'role_id.required' => 'Please select a role.',
            'role_id.exists'   => 'Selected role does not exist.',
            'permissions.array' => 'Permissions must be an array.',
            'permissions.*.exists' => 'One or more permissions are invalid.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        $roleId = $request->role_id;
        $permissions = $request->permissions ?? [];

        RolePermission::where('role_id', $roleId)->forceDelete();

        foreach ($permissions as $permissionId) {
            RolePermission::create([
                'role_id' => $roleId,
                'permission_id' => $permissionId
            ]);
        }

        return redirect()->route('users.permissions.index')->with('success', 'Permissions updated successfully.');
    }

    public function editRolePermissions($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all();
        $rolePermissions = DB::table('role_permission')
            ->where('role_id', $roleId)
            ->pluck('permission_id')
            ->toArray();

        return view('roles.permissions.index', compact('role', 'permissions', 'rolePermissions'));
    }

    public function updateRolePermissions(Request $request, $roleId)
    {
        DB::table('role_permission')->where('role_id', $roleId)->delete();

        if ($request->permissions) {
            foreach ($request->permissions as $permissionId) {
                DB::table('role_permission')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId
                ]);
            }
        }

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }

    // public function index()
    // {
    //     $roles = Role::with('permissions')->get();
    //     $menuData = json_decode(File::get(resource_path('menu/verticalMenu.json')), true);
    //     $menuItems = $this->flattenMenu($menuData['menu']);
    //     return view('masters.permissions.index', compact('roles', 'menuItems'));
    // }

    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'role_id' => 'required|exists:roles,id',
    //         'permissions' => 'array',
    //     ]);

    //     $role = Role::findOrFail($request->role_id);
    //     $role->permissions()->detach(); // Clear existing permissions

    //     foreach ($request->permissions ?? [] as $menuSlug => $types) {
    //         foreach ($types as $type) {
    //             $permission = Permission::firstOrCreate([
    //                 'menu_slug' => $menuSlug,
    //                 'permission_type' => $type,
    //             ]);
    //             $role->permissions()->attach($permission->id);
    //         }
    //     }

    //     return redirect()->route('users.permissions.index')->with('success', 'Permissions updated successfully.');
    // }

    // private function flattenMenu($menu, $parentSlug = '')
    // {
    //     $items = [];
    //     foreach ($menu as $item) {
    //         if (!isset($item['slug']) || !isset($item['name'])) {
    //             continue;
    //         }

    //         $slug = $item['slug'];
    //         $items[] = ['slug' => $slug, 'name' => $item['name']];

    //         if (isset($item['submenu']) && is_array($item['submenu'])) {
    //             $items = array_merge($items, $this->flattenMenu($item['submenu'], $slug));
    //         }
    //     }
    //     return $items;
    // }
}

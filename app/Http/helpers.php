<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// if (!function_exists('getUserPermissions')) {
//     function getUserPermissions()
//     {
//         if (!auth()->check()) return [];

//         return DB::table('role_permissions')
//             ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
//             ->where('role_permissions.role_id', auth()->user()->role_id)
//             ->pluck('permissions.name')
//             ->toArray();
//     }
// }


// function hasPermission($permissions)
// {
//     if (!Auth::check()) {
//         return false;
//     }

//     if (is_string($permissions)) {
//         $permissions = [$permissions];
//     }

//     $userPermissions = getUserPermissions();
//     return !empty(array_intersect($permissions, $userPermissions));
// }
if (!function_exists('loadUserPermissions')) {
    function loadUserPermissions()
    {
        if (!Auth::check()) {
            session()->forget('user_permissions');
            return;
        }

        $permissions = DB::table('role_permissions')
            ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
            ->where('role_permissions.role_id', Auth::user()->role_id)
            ->pluck('permissions.name')
            ->toArray();

        session(['user_permissions' => $permissions]);
    }
}

// if (!function_exists('getUserPermissions')) {
//     function getUserPermissions()
//     {
//         if (!auth()->check()) {
//             return [];
//         }

//         // Retrieve from session instead of hitting the DB every time
//         return session('user_permissions', []);
//     }
// }

if (!function_exists('hasPermission')) {
    function hasPermission($permissions)
    {
        if (!Auth::check()) {
            return false;
        }

        if (is_string($permissions)) {
            $permissions = [$permissions];
        }

        $userPermissions = session('user_permissions', []);
        return !empty(array_intersect($permissions, $userPermissions));
    }
}


// if (!function_exists('loadUserPermissions')) {
//     function loadUserPermissions($userId = null)
//     {
//         $userId = $userId ?? auth()->id();

//         $permissions = DB::table('role_permissions')
//             ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
//             ->where('role_permissions.role_id', auth()->user()->role_id)
//             ->pluck('permissions.name')
//             ->toArray();

//         session(['user_permissions' => $permissions]);
//     }
// }

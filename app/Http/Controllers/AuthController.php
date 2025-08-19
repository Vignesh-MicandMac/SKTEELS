<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function index()
    // {

    //     // if (Auth::check()) {
    //     //     return $this->redirectBasedOnRole();
    //     // }
    //     return view('login');
    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'name' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt($credentials, $request->has('remember'))) {
    //         $request->session()->regenerate();
    //         // dd(['test' => $request->all(), 'auth' => auth()->user()]);
    //         return $this->redirectBasedOnRole();
    //     }

    //     return back()->withErrors([
    //         'name' => 'The provided credentials do not match our records.',
    //     ])->withInput($request->only('name'));
    // }

    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect()->route('login');
    // }

    // // protected function redirectBasedOnRole()
    // // {
    // //     // dd(['auth' => Auth::user()]);
    // //     $auth_user_id = Auth::user();
    // //     $user_id = $auth_user_id->id;
    // //     dd($user_id);
    // //     $user = User::with('role.permissions')->find($auth_user_id);
    // //     $role = $user->role->name ?? 'Default';

    // //     switch ($role) {

    // //         case 'admin':
    // //             if ($user->hasPermission('dashboard', 'view')) {
    // //                 Log::info('Redirecting to dashboard');

    // //                 return redirect()->route('dashboard');
    // //             }
    // //             break;
    // //         case 'dealer':
    // //             if ($user->hasPermission('masters.dealers.index', 'view')) {
    // //                 Log::info('Redirecting to dashboard2222');

    // //                 return redirect()->route('masters.dealers.index');
    // //             }
    // //             break;
    // //         case 'promotor':
    // //             if ($user->hasPermission('activity.promotors-approval', 'view')) {
    // //                 Log::info('Redirecting to dashboard333333');
    // //                 return redirect()->route('activity.promotors-approval');
    // //             }
    // //             break;
    // //     }

    // //     // Fallback: Redirect to first accessible menu item
    // //     $menuData = json_decode(File::get(resource_path('menu/verticalMenu.json')), true)['menu'];
    // //     foreach ($menuData as $menu) {
    // //         if (isset($menu['menuHeader'])) {
    // //             continue;
    // //         }
    // //         if (isset($menu['submenu'])) {
    // //             foreach ($menu['submenu'] as $submenu) {
    // //                 if ($user->hasPermission($submenu['slug'], 'view')) {
    // //                     return redirect()->route($submenu['slug']);
    // //                 }
    // //             }
    // //         } elseif ($user->hasPermission($menu['slug'], 'view')) {
    // //             return redirect()->route($menu['slug']);
    // //         }
    // //     }

    // //     return redirect()->route('login')->with('error', 'No accessible routes for your role.');
    // // }

    // // protected function redirectBasedOnRole()
    // // {
    // //     $auth_user = Auth::user(); // This is already the User model
    // //     $user_id = $auth_user->id;

    // //     // Use the existing $auth_user model with eager loading
    // //     $user = User::with('role.permissions')->find($user_id);

    // //     $role = $user->role->name ?? 'Default';

    // //     switch ($role) {
    // //         case 'admin':
    // //             if ($user->hasPermission('dashboard', 'view')) {
    // //                 Log::info('Redirecting to dashboard');
    // //                 return redirect()->route('dashboard');
    // //             }
    // //             break;

    // //         case 'dealer':
    // //             if ($user->hasPermission('masters.dealers.index', 'view')) {
    // //                 Log::info('Redirecting to dashboard2222');
    // //                 return redirect()->route('masters.dealers.index');
    // //             }
    // //             break;

    // //         case 'promotor':
    // //             if ($user->hasPermission('activity.promotors-approval', 'view')) {
    // //                 Log::info('Redirecting to dashboard333333');
    // //                 return redirect()->route('activity.promotors-approval');
    // //             }
    // //             break;
    // //     }

    // //     // Fallback: Redirect to first accessible menu item
    // //     $menuData = json_decode(File::get(resource_path('menu/verticalMenu.json')), true)['menu'];
    // //     foreach ($menuData as $menu) {
    // //         if (isset($menu['menuHeader'])) {
    // //             continue;
    // //         }
    // //         if (isset($menu['submenu'])) {
    // //             foreach ($menu['submenu'] as $submenu) {
    // //                 if ($user->hasPermission($submenu['slug'], 'view')) {
    // //                     return redirect()->route($submenu['slug']);
    // //                 }
    // //             }
    // //         } elseif ($user->hasPermission($menu['slug'], 'view')) {
    // //             return redirect()->route($menu['slug']);
    // //         }
    // //     }

    // //     return redirect()->route('home'); // fallback if no match
    // // }

    // protected function redirectBasedOnRole()
    // {
    //     $authUser = Auth::user(); // This returns a User model instance

    //     if (!$authUser) {
    //         abort(401, 'Unauthenticated');
    //     }

    //     $userId = $authUser->id; // This should work
    //     // dd($userId); // Uncomment for debugging

    //     // Load user with role and permissions
    //     $user = User::with('role.permissions')->find($userId); // Use $userId here, not object

    //     if (!$user) {
    //         abort(404, 'User not found');
    //     }

    //     $role = $user->role->name ?? 'Default';

    //     // switch ($role) {
    //     //     case 'admin':
    //     //         if ($user->hasPermission('dashboard', 'view')) {
    //     //             Log::info('Redirecting to dashboard');
    //     //             return redirect()->route('dashboard');
    //     //         }
    //     //         break;

    //     //     case 'dealer':
    //     //         if ($user->hasPermission('masters.dealers.index', 'view')) {
    //     //             Log::info('Redirecting to dealer dashboard');
    //     //             return redirect()->route('masters.dealers.index');
    //     //         }
    //     //         break;

    //     //     case 'promotor':
    //     //         if ($user->hasPermission('activity.promotors-approval', 'view')) {
    //     //             Log::info('Redirecting to promotor approval');
    //     //             return redirect()->route('activity.promotors-approval');
    //     //         }
    //     //         break;
    //     // }

    //     // Fallback: Redirect to first accessible menu item
    //     // $menuData = json_decode(File::get(resource_path('menu/verticalMenu.json')), true)['menu'];
    //     // dd($menuData);
    //     // foreach ($menuData as $menu) {
    //     //     dd($menu);
    //     //     if (isset($menu['menuHeader'])) {
    //     //         continue;
    //     //     }

    //     //     if (isset($menu['submenu'])) {
    //     //         dd($menu['submenu']);
    //     //         foreach ($menu['submenu'] as $submenu) {
    //     //             if ($user->hasPermission($submenu['slug'], 'view')) {
    //     //                 return redirect()->route($submenu['slug']);
    //     //             }
    //     //         }
    //     //     } elseif ($user->hasPermission($menu['slug'], 'view')) {
    //     //         return redirect()->route($menu['slug']);
    //     //     }
    //     // }

    //     // // Final fallback
    //     // return redirect()->route('fallback.route'); // Set a default route

    //     $menuJson = File::get(resource_path('menu/verticalMenu.json'));
    //     $menuData = json_decode($menuJson, true);

    //     if (!isset($menuData['menu'])) {
    //         Log::error("Menu data is missing or malformed");
    //         return redirect()->route('fallback.route');
    //     }

    //     foreach ($menuData['menu'] as $menu) {
    //         if (isset($menu['menuHeader'])) {
    //             continue; // Skip headers
    //         }

    //         // Check if menu item is accessible
    //         if (isset($menu['slug']) && $user->hasPermission($menu['slug'], 'view')) {
    //             return redirect()->route($menu['slug']);
    //         }

    //         // Check submenu if exists
    //         if (isset($menu['submenu']) && is_array($menu['submenu'])) {
    //             foreach ($menu['submenu'] as $submenu) {
    //                 if (isset($submenu['slug']) && $user->hasPermission($submenu['slug'], 'view')) {
    //                     return redirect()->route($submenu['slug']);
    //                 }
    //             }
    //         }
    //     }

    //     // If nothing matched
    //     Log::warning("No accessible route found for user ID {$user->id}");
    //     return redirect()->route('fallback.route'); // Make sure this exists
    // }

    public function index()
    {
        // if (Auth::check()) {
        //     return $this->redirectBasedOnRole();
        // }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ], [
            'email.exists' => 'This email is not registered.',
            'email.required' => 'Please enter your email.',
            'password.required' => 'Please enter your password.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (!Auth::check()) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Login failed. Please try again.');
            }
            loadUserPermissions();
            return redirect()->route('dashboard')->with('success', 'Logged in successfully.');
        }

        return back()->with('error', 'Incorrect email or password.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged Out Successfully');
    }

    // protected function redirectBasedOnRole()
    // {
    //     //     $user = Auth::user();
    //     //     if (!$user) {
    //     //         Log::error('User not authenticated in redirectBasedOnRole');
    //     //         return redirect()->route('login');
    //     //     }

    //     //     $user = User::with('role.permissions')->find($user->id);
    //     //     if (!$user) {
    //     //         Log::error('User not found in redirectBasedOnRole');
    //     //         return redirect()->route('login');
    //     //     }

    //     //     $role = $user->role->name ?? 'Default';
    //     //     Log::info("User ID: {$user->id}, Role: {$role}");

    //     //     switch (strtolower($role)) {
    //     //         case 'admin':
    //     //             if ($user->hasPermission('dashboard', 'view')) {
    //     //                 Log::info('Redirecting to dashboard');
    //     //                 return redirect()->route('dashboard');
    //     //             }
    //     //             break;
    //     //         case 'dealer':
    //     //             if ($user->hasPermission('masters.dealers.index', 'view')) {
    //     //                 Log::info('Redirecting to dealer dashboard');
    //     //                 return redirect()->route('masters.dealers.index');
    //     //             }
    //     //             break;
    //     //         case 'promotor':
    //     //             if ($user->hasPermission('activity.promotors-approval', 'view')) {
    //     //                 Log::info('Redirecting to promotor approval');
    //     //                 return redirect()->route('activity.promotors-approval');
    //     //             }
    //     //             break;
    //     //     }

    //     //     try {
    //     //         $menuJson = File::get(resource_path('data/menu.json'));
    //     //         $menuData = json_decode($menuJson, true);
    //     //         if (!isset($menuData['menu'])) {
    //     //             Log::error('Menu data is missing or malformed');
    //     //             return redirect()->route('login')->with('error', 'Menu configuration error');
    //     //         }

    //     //         foreach ($menuData['menu'] as $menu) {
    //     //             if (isset($menu['menuHeader'])) {
    //     //                 continue;
    //     //             }
    //     //             if (isset($menu['submenu']) && is_array($menu['submenu'])) {
    //     //                 foreach ($menu['submenu'] as $submenu) {
    //     //                     if (isset($submenu['slug']) && $user->hasPermission($submenu['slug'], 'view')) {
    //     //                         Log::info("Redirecting to submenu: {$submenu['slug']}");
    //     //                         return redirect()->route($submenu['slug']);
    //     //                     }
    //     //                 }
    //     //             } elseif (isset($menu['slug']) && $user->hasPermission($menu['slug'], 'view')) {
    //     //                 Log::info("Redirecting to menu: {$menu['slug']}");
    //     //                 return redirect()->route($menu['slug']);
    //     //             }
    //     //         }
    //     //     } catch (\Exception $e) {
    //     //         Log::error("Failed to load menu.json: {$e->getMessage()}");
    //     //         return redirect()->route('login')->with('error', 'Menu configuration error');
    //     //     }

    //     //     Log::warning("No accessible route found for user ID {$user->id}");
    //     //     return redirect()->route('login')->with('error', 'No accessible routes for your role.');
    //     // }

    //     $user = Auth::user();
    //     if (!$user) {
    //         Log::error('User not authenticated in redirectBasedOnRole');
    //         return redirect()->route('login');
    //     }

    //     $user = User::with('role.permissions')->find($user->id);
    //     if (!$user) {
    //         Log::error('User not found in redirectBasedOnRole');
    //         return redirect()->route('login');
    //     }

    //     $role = $user->role->name ?? 'Default';
    //     Log::info("User ID: {$user->id}, Role: {$role}");
    //     //add the user deatils to session 
    //     Session::put('user_id', $user->id);
    //     Session::put('role_name', $user->role->name);

    //     switch (strtolower($role)) {
    //         case 'admin':
    //             if ($user->hasPermission('dashboard', 'view')) {
    //                 Log::info('Redirecting to dashboard');
    //                 return redirect()->route('dashboard');
    //             }
    //             break;
    //         case 'dealer':
    //             if ($user->hasPermission('masters.dealers.index', 'view')) {
    //                 Log::info('Redirecting to dealer dashboard');
    //                 return redirect()->route('masters.dealers.index');
    //             }
    //             break;
    //         case 'promotor':
    //             if ($user->hasPermission('activity.promotors-approval', 'view')) {
    //                 Log::info('Redirecting to promotor approval');
    //                 return redirect()->route('activity.promotors-approval');
    //             }
    //             break;
    //     }

    //     try {
    //         $menuJson = File::get(resource_path('menu/verticalMenu.json'));
    //         $menuData = json_decode($menuJson, true);
    //         if (!isset($menuData['menu'])) {
    //             Log::error('Menu data is missing or malformed');
    //             return redirect()->route('login')->with('error', 'Menu configuration error');
    //         }

    //         foreach ($menuData['menu'] as $menu) {
    //             if (isset($menu['menuHeader'])) {
    //                 continue;
    //             }
    //             if (isset($menu['submenu']) && is_array($menu['submenu'])) {
    //                 foreach ($menu['submenu'] as $submenu) {
    //                     if (isset($submenu['slug']) && $user->hasPermission($submenu['slug'], 'view')) {
    //                         Log::info("Redirecting to submenu: {$submenu['slug']}");
    //                         return redirect()->route($submenu['slug']);
    //                     }
    //                 }
    //             } elseif (isset($menu['slug']) && $user->hasPermission($menu['slug'], 'view')) {
    //                 Log::info("Redirecting to menu: {$menu['slug']}");
    //                 return redirect()->route($menu['slug']);
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         Log::error("Failed to load menu.json: {$e->getMessage()}");
    //         return redirect()->route('login')->with('error', 'Menu configuration error');
    //     }

    //     Log::warning("No accessible route found for user ID {$user->id}");
    //     return redirect()->route('login')->with('error', 'No accessible routes for your role.');
    // }
}

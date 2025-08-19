<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // try {
    //   $menuJson = File::get(resource_path('menu/verticalMenu.json'));
    //   $menuDataRaw = json_decode($menuJson, true);
    //   if (!isset($menuDataRaw['menu'])) {
    //     Log::error('Menu data is missing or malformed in menu.json');
    //     View::share('menuData', []);
    //     return;
    //   }
    //   $menuData = $menuDataRaw['menu'];
    //   // Ensure each menu item is an array
    //   foreach ($menuData as &$menu) {
    //     if (is_object($menu)) {
    //       $menu = (array) $menu;
    //     }
    //     if (isset($menu['submenu']) && is_array($menu['submenu'])) {
    //       foreach ($menu['submenu'] as &$submenu) {
    //         if (is_object($submenu)) {
    //           $submenu = (array) $submenu;
    //         }
    //       }
    //     }
    //   }
    //   Log::info('menuData shared successfully', ['count' => count($menuData), 'structure' => $menuData]);
    //   View::share('menuData', $menuData);
    // } catch (\Exception $e) {
    //   Log::error('Failed to load menu.json: ' . $e->getMessage());
    //   View::share('menuData', []);
    // }
  }
}

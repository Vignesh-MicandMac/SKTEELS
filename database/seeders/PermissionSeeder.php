<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();

         $menus = [
            'dashboard' => ['view'],
            'dealers' => ['view', 'add', 'edit', 'delete'],
            'executives' => ['view', 'add', 'edit', 'delete'],
            'executive_mapping' => ['view', 'add', 'edit', 'delete'],
            'product_upload' => ['view', 'add', 'edit', 'delete'],
            'promotors_type' => ['view', 'add', 'edit', 'delete'],
            'promotors' => ['view', 'add', 'edit', 'delete'],
            'brands' => ['view', 'add', 'edit', 'delete'],
            'stock_points' => ['view', 'add', 'edit', 'delete'],
            'add_stock' => ['view', 'add', 'edit', 'delete'],
            'edit_stock' => ['view', 'add', 'edit', 'delete'],
            'closing_stock_update' => ['view', 'add', 'edit', 'delete'],
            'sale_entry_approval' => ['view', 'add', 'edit', 'delete'],
            'promotors_approval' => ['view', 'add', 'edit', 'delete'],
            'redeem_approval' => ['view', 'add', 'edit', 'delete'],
            'roles' => ['view', 'add', 'edit', 'delete'],
            'users' => ['view', 'add', 'edit', 'delete'],
            'user_role_permission' => ['view', 'add', 'edit', 'delete'],
        ];

        $now = Carbon::now();

        $data = [];

        foreach ($menus as $menu => $actions) {
            foreach ($actions as $action) {
                $data[] = [
                    'name'       => "{$action}_{$menu}",
                    'label'      => ucfirst($action) . ' ' . ucwords(str_replace('_', ' ', $menu)),
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
        }

        DB::table('permissions')->insert($data);
        
        // $permissions = [
        //     ['name' => 'view_dashboard', 'label' => 'Dashboard'],
        //     ['name' => 'view_dealers', 'label' => 'Dealers'],
        //     ['name' => 'view_executives', 'label' => 'Executives'],
        //     ['name' => 'view_executive_mapping', 'label' => 'Executive Mappinng'],
        //     ['name' => 'view_product_upload', 'label' => 'Product Upload'],
        //     ['name' => 'view_promotors_type', 'label' => 'Promotors Type'],
        //     ['name' => 'view_promotors', 'label' => 'Promotors'],
        //     ['name' => 'view_brands', 'label' => 'Brands'],
        //     ['name' => 'view_stock_points', 'label' => 'Stock Points'],
        //     ['name' => 'view_add_stock', 'label' => 'Add Stock'],
        //     ['name' => 'view_edit_stock', 'label' => 'Edit Stock'],
        //     ['name' => 'view_closing_stock_update', 'label' => 'Closing Stock Update'],
        //     ['name' => 'view_sale_entry_approval', 'label' => 'Sale Entry Approval'],
        //     ['name' => 'view_promotors_approval', 'label' => 'Promotors Approval'],
        //     ['name' => 'view_redeem_approval', 'label' => 'Redeem Approval'],
        //     ['name' => 'view_roles', 'label' => 'Roles'],
        //     ['name' => 'view_users', 'label' => 'User'],
        //     ['name' => 'view_user_role_permission', 'label' => 'User Role Permission'],
        // ];

        // DB::table('permissions')->insert($permissions);
    }
}

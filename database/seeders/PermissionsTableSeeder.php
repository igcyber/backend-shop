<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permission dashboard
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.sales_chart', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.sales_today', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.profits_today', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.best_selling_product', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.product_stock', 'guard_name' => 'web']);

        //permission front
        Permission::create(['name' => 'front.index', 'guard_name' => 'web']);

        //permission users
        Permission::create(['name' => 'users.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'web']);

        //permission roles
        Permission::create(['name' => 'roles.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'web']);

        //permission permissions
        Permission::create(['name' => 'permissions.index', 'guard_name' => 'web']);

        //permission categories
        Permission::create(['name' => 'categories.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'categories.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'categories.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'categories.delete', 'guard_name' => 'web']);

        //permission products
        Permission::create(['name' => 'products.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.delete', 'guard_name' => 'web']);

        //permission customers
        Permission::create(['name' => 'customers.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'customers.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'customers.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'customers.delete', 'guard_name' => 'web']);

        //permission vendors
        Permission::create(['name' => 'vendors.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendors.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendors.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendors.delete', 'guard_name' => 'web']);

        //permission units
        Permission::create(['name' => 'units.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'units.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'units.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'units.delete', 'guard_name' => 'web']);

        //permission orders
        Permission::create(['name' => 'orders.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'orders.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'orders.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'orders.delete', 'guard_name' => 'web']);

        //permission detail products
        Permission::create(['name' => 'detail_product.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'detail_product.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'detail_product.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'detail_product.delete', 'guard_name' => 'web']);
    }
}

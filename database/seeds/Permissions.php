<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Products
        Permission::create([
            'name' => 'products-create',
            'display_name' => 'Create Products', 
            'description' => 'Create Products', 
        ]);
        
        Permission::create([
            'name' => 'products-read',
            'display_name' => 'Read Products', 
            'description' => 'Read Products', 
        ]);

        Permission::create([
            'name' => 'products-update',
            'display_name' => 'Update Products', 
            'description' => 'Update Products', 
        ]);
        
        Permission::create([
            'name' => 'products-delete',
            'display_name' => 'Delete Products', 
            'description' => 'Delete Products', 
        ]);

        
        //Permissions
        Permission::create([
            'name' => 'permissions-create',
            'display_name' => 'Create Permissions', 
            'description' => 'Create Permissions', 
        ]);
        
        Permission::create([
            'name' => 'permissions-read',
            'display_name' => 'Read Permissions', 
            'description' => 'Read Permissions', 
        ]);

        Permission::create([
            'name' => 'permissions-update',
            'display_name' => 'Update Permissions', 
            'description' => 'Update Permissions', 
        ]);
        
        Permission::create([
            'name' => 'permissions-delete',
            'display_name' => 'Delete Permissions', 
            'description' => 'Delete Permissions', 
        ]);

        //Orders
        Permission::create([
            'name' => 'orders-create',
            'display_name' => 'Create Orders', 
            'description' => 'Create Orders', 
        ]);
        
        Permission::create([
            'name' => 'orders-read',
            'display_name' => 'Read Orders', 
            'description' => 'Read Orders', 
        ]);
    }
}

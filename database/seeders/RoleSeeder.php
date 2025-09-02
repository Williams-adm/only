<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('permission:cache-reset');

        $admin = Role::create([
            'name' => 'admin',
        ]);

        $admin->syncPermissions([
            'access dashboard',
            'manage users',
            'manage options',
            'manage brands',
            'manage categories',
            'manage subcategories',
            'manage products',
            'manage covers',
            'manage couriers',
            'manage orders',
            'manage shipments',
        ]);

        $user = User::findOrFail(1);
        $user->assignRole('admin');
    }
}

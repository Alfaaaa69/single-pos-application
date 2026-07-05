<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $cashierRole = Role::where('name', 'cashier')->first();

        User::updateOrCreate(
            ['email' => 'admin@singlepos.com'],
            [
                'name' => 'Admin SinglePOS',
                'password' => 'password',
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@singlepos.com'],
            [
                'name' => 'Kasir Demo',
                'password' => 'password',
                'role_id' => $cashierRole->id,
                'is_active' => true,
            ]
        );
    }
}

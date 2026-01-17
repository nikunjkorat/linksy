<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@linksy.local'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => User::ROLE_SUPER_ADMIN,
                'company_id' => null,
            ]
        );
    }
}

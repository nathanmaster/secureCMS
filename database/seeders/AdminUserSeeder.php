<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUsers = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@securecms.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Store Manager',
                'email' => 'manager@securecms.com',
                'password' => Hash::make('manager123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Demo User',
                'email' => 'demo@securecms.com',
                'password' => Hash::make('demo123'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($adminUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Admin users created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@securecms.com / admin123');
        $this->command->info('Manager: manager@securecms.com / manager123');
        $this->command->info('Demo: demo@securecms.com / demo123');
    }
}

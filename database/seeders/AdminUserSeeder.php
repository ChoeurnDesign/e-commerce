<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create/Update Admin User
        $adminUser = User::where('email', 'admin@shopexpress.com')->first();

        if ($adminUser) {
            // Update existing user to admin
            $adminUser->update([
                'role' => 'admin',
                'name' => 'ChoeurnDesign'
            ]);
            $this->command->info('Existing admin user updated.');
        } else {
            // Create new admin user
            User::create([
                'name' => 'ChoeurnDesign',
                'email' => 'admin@shopexpress.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->command->info('New admin user created.');
        }

        // Create/Update Test User
        $testUser = User::where('email', 'test@shopexpress.com')->first();

        if ($testUser) {
            // Update existing user
            $testUser->update([
                'role' => 'user',
                'name' => 'Test User'
            ]);
            $this->command->info('Existing test user updated.');
        } else {
            // Create new test user
            User::create([
                'name' => 'Test User',
                'email' => 'test@shopexpress.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
            $this->command->info('New test user created.');
        }

        // Create additional demo users if needed
        $demoUsers = [
            [
                'name' => 'John Doe',
                'email' => 'john@shopexpress.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@shopexpress.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@shopexpress.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        ];

        foreach ($demoUsers as $userData) {
            $existingUser = User::where('email', $userData['email'])->first();

            if (!$existingUser) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'role' => $userData['role'],
                    'email_verified_at' => now(),
                ]);
                $this->command->info("Demo user {$userData['name']} created.");
            }
        }
    }
}

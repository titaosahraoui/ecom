<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Clear existing users (optional - be careful in production)
        // User::truncate();

        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => User::ROLE_ADMIN]);
        $commercialRole = Role::firstOrCreate(['name' => User::ROLE_COMMERCIAL]);
        $customerRole = Role::firstOrCreate(['name' => User::ROLE_CUSTOMER]);

        // Create admin user
        $admin = User::create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin@myboutique.com',
            'password' => Hash::make('password123'),
            'phone' => '+1234567890',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // Create commercial user
        $commercial = User::create([
            'nom' => 'Commercial',
            'prenom' => 'Manager',
            'role' => User::ROLE_COMMERCIAL,
            'email' => 'commercial@myboutique.com',
            'password' => Hash::make('password123'),
            'phone' => '+1987654321',
            'email_verified_at' => now(),
        ]);
        $commercial->assignRole($commercialRole);

        // Create regular customers
        $customers = [
            [
                'nom' => 'Doe',
                'prenom' => 'John',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('customer123'),
                'phone' => '+1555123456',
                'email_verified_at' => now(),
            ],
            [
                'nom' => 'Smith',
                'prenom' => 'Jane',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('customer123'),
                'phone' => '+1555987654',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($customers as $customer) {
            $user = User::create($customer);
            $user->assignRole($customerRole);
        }

        // Generate 10 more random customers
        // User::factory()->count(10)->create()->each(function ($user) use ($customerRole) {
        //     $user->assignRole($customerRole);
        // });
    }
}

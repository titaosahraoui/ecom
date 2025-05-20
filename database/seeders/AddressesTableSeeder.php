<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        // Get all users
        $users = User::all();

        // Sample addresses data
        $addresses = [
            [
                'address_line1' => '123 Main Street',
                'address_line2' => 'Apt 4B',
                'city' => 'New York',
                'postal_code' => '10001',
                'country' => 'United States',
                'is_default' => true,
            ],
            [
                'address_line1' => '456 Oak Avenue',
                'city' => 'Los Angeles',
                'postal_code' => '90001',
                'country' => 'United States',
                'is_default' => false,
            ],
            [
                'address_line1' => '789 Maple Road',
                'address_line2' => 'Floor 3',
                'city' => 'Chicago',
                'postal_code' => '60601',
                'country' => 'United States',
                'is_default' => true,
            ],
            [
                'address_line1' => '101 Pine Lane',
                'city' => 'Houston',
                'postal_code' => '77001',
                'country' => 'United States',
                'is_default' => false,
            ],
            // Add more sample addresses as needed
        ];

        // Assign addresses to users
        foreach ($users as $index => $user) {
            // Make sure we don't exceed the addresses array
            $addressIndex = $index % count($addresses);
            $addressData = $addresses[$addressIndex];

            // Create address for user
            $user->addresses()->create($addressData);

            // Add a second address for some users
            if ($index % 2 === 0 && isset($addresses[$addressIndex + 1])) {
                $secondAddressData = $addresses[$addressIndex + 1];
                $user->addresses()->create($secondAddressData);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    public function run()
    {
        // Get all users
        $users = User::all();

        // Sample payment methods data
        $paymentMethods = [
            [
                'card_type' => 'Visa',
                'last_four' => '4242',
                'expiry_month' => 12,
                'expiry_year' => 2025,
                'card_holder_name' => 'John Doe',
                'is_default' => true,
            ],
            [
                'card_type' => 'Mastercard',
                'last_four' => '5555',
                'expiry_month' => 6,
                'expiry_year' => 2024,
                'card_holder_name' => 'John Doe',
                'is_default' => false,
            ],
            [
                'card_type' => 'American Express',
                'last_four' => '3782',
                'expiry_month' => 3,
                'expiry_year' => 2026,
                'card_holder_name' => 'Jane Smith',
                'is_default' => true,
            ],
            [
                'card_type' => 'Visa',
                'last_four' => '1881',
                'expiry_month' => 9,
                'expiry_year' => 2023,
                'card_holder_name' => 'Jane Smith',
                'is_default' => false,
            ],
            // Add more sample payment methods as needed
        ];

        // Assign payment methods to users
        foreach ($users as $index => $user) {
            // Make sure we don't exceed the payment methods array
            $methodIndex = $index % count($paymentMethods);
            $paymentData = $paymentMethods[$methodIndex];

            // Create payment method for user
            $user->paymentMethods()->create($paymentData);

            // Add a second payment method for some users
            if ($index % 2 === 0 && isset($paymentMethods[$methodIndex + 1])) {
                $secondPaymentData = $paymentMethods[$methodIndex + 1];
                $user->paymentMethods()->create($secondPaymentData);
            }
        }
    }
}

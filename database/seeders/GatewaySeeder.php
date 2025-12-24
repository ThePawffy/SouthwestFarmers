<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    public function run(): void
    {
        Gateway::insert([

            [
                'id' => 1,
                'name' => 'Stripe',
                'currency_id' => 2,
                'mode' => 'Sandbox',
                'status' => 1,
                'charge' => 2,
                'image' => 'uploads/25/01/1736320810-265.svg',
                'data' => json_encode([
                    'stripe_key' => env('STRIPE_PUBLIC_KEY'),
                    'stripe_secret' => env('STRIPE_SECRET_KEY'),
                ]),
                'namespace' => 'App\\Library\\StripeGateway',
                'is_manual' => 0,
                'accept_img' => 0,
                'phone_required' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 2,
                'name' => 'mollie',
                'currency_id' => 2,
                'mode' => 'Sandbox',
                'status' => 1,
                'charge' => 2,
                'image' => 'uploads/25/01/1736320939-855.svg',
                'data' => json_encode([
                    'api_key' => env('MOLLIE_API_KEY'),
                ]),
                'namespace' => 'App\\Library\\Mollie',
                'is_manual' => 0,
                'accept_img' => 0,
                'phone_required' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 3,
                'name' => 'paypal',
                'currency_id' => 2,
                'mode' => 'Sandbox',
                'status' => 1,
                'charge' => 2,
                'image' => 'uploads/25/01/1736321116-229.svg',
                'data' => json_encode([
                    'client_id' => env('PAYPAL_CLIENT_ID'),
                    'client_secret' => env('PAYPAL_CLIENT_SECRET'),
                ]),
                'namespace' => 'App\\Library\\Paypal',
                'is_manual' => 0,
                'accept_img' => 0,
                'phone_required' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Repeat SAME PATTERN for all gateways
            // Paystack, Razorpay, Instamojo, Flutterwave, etc.
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class TapPaymentSeeder extends Seeder
{
    public function run(): void
    {
        Gateway::insert([
            [
                'name' => 'Tap Payment',
                'currency_id' => 116,
                'mode' => 'Sandbox',
                'status' => 1,
                'charge' => 2,
                'image' => null,
                'data' => json_encode([
                    'secret_key' => env('TAP_SECRET_KEY'),
                    'currency' => 'SAR',
                ]),
                'manual_data' => null,
                'is_manual' => 0,
                'accept_img' => 0,
                'namespace' => 'App\\Library\\TapPayment',
                'phone_required' => 0,
                'instructions' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

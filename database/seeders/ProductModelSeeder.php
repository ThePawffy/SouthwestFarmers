<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Seeder;

class ProductModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_models = array(
            array('business_id' => '1', 'name' => 'Rice Pack', 'status' => '1', 'created_at' => '2025-08-23 08:32:00', 'updated_at' => '2025-08-23 08:32:00'),
            array('business_id' => '1', 'name' => 'Vegetable Bag', 'status' => '1', 'created_at' => '2025-08-23 08:32:00', 'updated_at' => '2025-08-23 08:32:00'),
            array('business_id' => '1', 'name' => 'Fruit Box', 'status' => '1', 'created_at' => '2025-08-23 08:32:00', 'updated_at' => '2025-08-23 08:32:00'),
            array('business_id' => '1', 'name' => 'Spice Jar', 'status' => '1', 'created_at' => '2025-08-23 08:32:00', 'updated_at' => '2025-08-23 08:32:00'),
            array('business_id' => '1', 'name' => 'Oil Bottle', 'status' => '1', 'created_at' => '2025-08-23 08:32:00', 'updated_at' => '2025-08-23 08:32:00'),
        );

        ProductModel::insert($product_models);
    }
}

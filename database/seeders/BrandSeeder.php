<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = array(
            array('business_id' => '1', 'brandName' => 'FreshPick', 'icon' => 'uploads/25/05/1748484797-149.png', 'description' => 'FreshPick provides fresh daily grocery essentials.', 'status' => '1', 'created_at' => '2025-05-27 13:08:28', 'updated_at' => '2025-05-27 13:08:28'),
            array('business_id' => '1', 'brandName' => 'GreenBasket', 'icon' => 'uploads/25/05/1748484933-257.png', 'description' => 'GreenBasket is your source for organic vegetables and fruits.', 'status' => '1', 'created_at' => '2025-05-27 13:08:28', 'updated_at' => '2025-05-27 13:08:28'),
            array('business_id' => '1', 'brandName' => 'DailyNeeds', 'icon' => 'uploads/25/05/1748484979-157.jpeg', 'description' => 'DailyNeeds covers all your essential grocery items.', 'status' => '1', 'created_at' => '2025-05-27 13:08:28', 'updated_at' => '2025-05-27 13:08:28'),
            array('business_id' => '1', 'brandName' => 'SuperMart', 'icon' => 'uploads/25/05/1748484955-440.png', 'description' => 'SuperMart brings quality grocery products for your family.', 'status' => '1', 'created_at' => '2025-05-27 13:08:28', 'updated_at' => '2025-05-27 13:08:28'),
        );

        Brand::insert($brands);
    }
}

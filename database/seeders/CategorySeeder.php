<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array(
            array('categoryName' => 'Rice', 'icon' => 'uploads/25/08/1756205075-93.png', 'business_id' => '1', 'variationCapacity' => '1', 'variationColor' => '0', 'variationSize' => '1', 'variationType' => '0', 'variationWeight' => '1', 'status' => '1', 'created_at' => '2025-08-18 09:20:10', 'updated_at' => '2025-08-23 11:34:09'),
            array('categoryName' => 'Fruits', 'icon' => 'uploads/25/08/1756205095-799.png', 'business_id' => '1', 'variationCapacity' => '0', 'variationColor' => '0', 'variationSize' => '0', 'variationType' => '0', 'variationWeight' => '0', 'status' => '1', 'created_at' => '2025-08-18 09:20:10', 'updated_at' => '2025-08-23 11:33:48'),
            array('categoryName' => 'Vegetables', 'icon' => 'uploads/25/08/1756205106-379.png', 'business_id' => '1', 'variationCapacity' => '0', 'variationColor' => '0', 'variationSize' => '0', 'variationType' => '0', 'variationWeight' => '0', 'status' => '1', 'created_at' => '2025-08-18 09:20:10', 'updated_at' => '2025-08-23 11:33:39'),
            array('categoryName' => 'Meat', 'icon' => 'uploads/25/08/1756205115-863.png', 'business_id' => '1', 'variationCapacity' => '0', 'variationColor' => '0', 'variationSize' => '0', 'variationType' => '0', 'variationWeight' => '0', 'status' => '1', 'created_at' => '2025-08-18 09:20:10', 'updated_at' => '2025-08-23 11:33:06')
        );
        Category::insert($categories);
    }
}

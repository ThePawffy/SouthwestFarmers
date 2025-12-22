<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $income_categories = array (
            array('categoryName' => 'Sales', 'business_id' => '1', 'categoryDescription' => 'All sales income', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('categoryName' => 'Delivery', 'business_id' => '1', 'categoryDescription' => 'Income for delivery', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('categoryName' => 'ReturnFee', 'business_id' => '1', 'categoryDescription' => 'Return fee income', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
        );

        IncomeCategory::insert($income_categories);
    }
}

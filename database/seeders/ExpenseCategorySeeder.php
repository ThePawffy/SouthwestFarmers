<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenses_categories = array (
            array('categoryName' => 'Supplier', 'business_id' => '1', 'categoryDescription' => 'Supplier expense', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('categoryName' => 'Rent', 'business_id' => '1', 'categoryDescription' => 'All rent expense', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('categoryName' => 'Utility', 'business_id' => '1', 'categoryDescription' => 'Utility bills', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
        );

        ExpenseCategory::insert($expenses_categories);
    }
}

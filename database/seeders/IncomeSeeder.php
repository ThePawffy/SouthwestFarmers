<?php

namespace Database\Seeders;

use App\Models\Income;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incomes = array(
            array('income_category_id' => '1', 'business_id' => '1', 'user_id' => '4', 'amount' => '4645', 'incomeFor' => 'Sales', 'paymentType' => 'Card', 'referenceNo' => '343343', 'note' => 'all done', 'incomeDate' => '2005-08-11 00:00:00',),
            array('income_category_id' => '2', 'business_id' => '1', 'user_id' => '4', 'amount' => '34345', 'incomeFor' => 'Delivery', 'paymentType' => 'Cash', 'referenceNo' => '264453', 'note' => 'all ok', 'incomeDate' => '2005-08-11 00:00:00',),
            array('income_category_id' => '3', 'business_id' => '1', 'user_id' => '4', 'amount' => '6896', 'incomeFor' => 'Return Fee', 'paymentType' => 'Check', 'referenceNo' => '462347', 'note' => 'all success', 'incomeDate' => '2005-08-11 00:00:00',),
        );

        Income::insert($incomes);
    }
}

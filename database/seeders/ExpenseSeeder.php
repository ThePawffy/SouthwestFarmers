<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenses = array(
            array('expense_category_id' => '1', 'business_id' => '1', 'user_id' => '4', 'amount' => '4645', 'expenseFor' => 'Supplier', 'paymentType' => 'Card', 'referenceNo' => '463443', 'note' => 'all done', 'expenseDate' => '2005-08-11 00:00:00'),
            array('expense_category_id' => '2', 'business_id' => '1', 'user_id' => '4', 'amount' => '34345', 'expenseFor' => 'Rent', 'paymentType' => 'Cash', 'referenceNo' => '264453', 'note' => 'all ok', 'expenseDate' => '2005-08-11 00:00:00'),
            array('expense_category_id' => '3', 'business_id' => '1', 'user_id' => '4', 'amount' => '6896', 'expenseFor' => 'Utility Bills', 'paymentType' => 'Check', 'referenceNo' => '462342', 'note' => 'all success', 'expenseDate' => '2005-08-11 00:00:00'),
        );

        Expense::insert($expenses);
    }
}

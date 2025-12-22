<?php

namespace Database\Seeders;

use App\Models\SaleReturn;
use App\Models\SaleReturnDetails;
use Illuminate\Database\Seeder;

class SaleReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sale_returns = array(
            array('business_id' => '1', 'sale_id' => '1', 'invoice_no' => 'SR01', 'return_date' => '2025-08-18 08:52:24', 'created_at' => '2025-08-18 08:52:24', 'updated_at' => '2025-08-18 08:52:24'),
            array('business_id' => '1', 'sale_id' => '2', 'invoice_no' => 'SR02', 'return_date' => '2025-08-18 08:52:44', 'created_at' => '2025-08-18 08:52:44', 'updated_at' => '2025-08-18 08:52:44'),
            array('business_id' => '1', 'sale_id' => '4', 'invoice_no' => 'SR03', 'return_date' => '2025-08-18 08:52:56', 'created_at' => '2025-08-18 08:52:56', 'updated_at' => '2025-08-18 08:52:56')
        );

        SaleReturn::insert($sale_returns);

        $sale_return_details = array(
            array('business_id' => '1', 'sale_return_id' => '1', 'sale_detail_id' => '1', 'return_amount' => '190.00', 'return_qty' => '1'),
            array('business_id' => '1', 'sale_return_id' => '2', 'sale_detail_id' => '2', 'return_amount' => '277.95', 'return_qty' => '1'),
            array('business_id' => '1', 'sale_return_id' => '3', 'sale_detail_id' => '4', 'return_amount' => '805.50', 'return_qty' => '1')
        );

        SaleReturnDetails::insert($sale_return_details);
    }
}

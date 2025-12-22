<?php

namespace Database\Seeders;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use Illuminate\Database\Seeder;

class PurchaseReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchase_returns = array(
            array('business_id' => '1', 'purchase_id' => '1', 'invoice_no' => 'PR01', 'return_date' => '2025-08-18 08:44:57', 'created_at' => '2025-08-18 08:44:57', 'updated_at' => '2025-08-18 08:44:57'),
            array('business_id' => '1', 'purchase_id' => '2', 'invoice_no' => 'PR02', 'return_date' => '2025-08-18 08:45:23', 'created_at' => '2025-08-18 08:45:23', 'updated_at' => '2025-08-18 08:45:23'),
            array('business_id' => '1', 'purchase_id' => '3', 'invoice_no' => 'PR03', 'return_date' => '2025-08-18 08:45:42', 'created_at' => '2025-08-18 08:45:42', 'updated_at' => '2025-08-18 08:45:42')
        );

        PurchaseReturn::insert($purchase_returns);

        $purchase_return_details = array(
            array('business_id' => '1', 'purchase_return_id' => '1', 'purchase_detail_id' => '1', 'return_amount' => '96.17', 'return_qty' => '1'),
            array('business_id' => '1', 'purchase_return_id' => '2', 'purchase_detail_id' => '2', 'return_amount' => '379.00', 'return_qty' => '2'),
            array('business_id' => '1', 'purchase_return_id' => '3', 'purchase_detail_id' => '3', 'return_amount' => '875.29', 'return_qty' => '4')
        );

        PurchaseReturnDetail::insert($purchase_return_details);
    }
}

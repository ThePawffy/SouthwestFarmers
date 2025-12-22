<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $stocks = array(
            array('business_id' => '1', 'product_id' => '1', 'batch_no' => NULL, 'productStock' => '25', 'productPurchasePrice' => '100', 'profit_percent' => '5', 'productSalePrice' => '105', 'productWholeSalePrice' => '180', 'productDealerPrice' => '150', 'mfg_date' => '2025-08-21', 'expire_date' => '2029-06-13', 'created_at' => '2025-08-21 08:48:42', 'updated_at' => '2025-08-21 08:48:42'),
            array('business_id' => '1', 'product_id' => '2', 'batch_no' => NULL, 'productStock' => '43', 'productPurchasePrice' => '210', 'profit_percent' => '23', 'productSalePrice' => '258.3', 'productWholeSalePrice' => '250', 'productDealerPrice' => '220', 'mfg_date' => '2025-08-21', 'expire_date' => '2030-06-19', 'created_at' => '2025-08-21 08:51:37', 'updated_at' => '2025-08-21 08:51:37'),
            array('business_id' => '1', 'product_id' => '3', 'batch_no' => NULL, 'productStock' => '43', 'productPurchasePrice' => '50', 'profit_percent' => '5', 'productSalePrice' => '100', 'productWholeSalePrice' => '90', 'productDealerPrice' => '70', 'mfg_date' => '2025-07-28', 'expire_date' => '2025-08-09', 'created_at' => '2025-08-21 08:52:51', 'updated_at' => '2025-08-21 08:52:51'),
            array('business_id' => '1', 'product_id' => '4', 'batch_no' => NULL, 'productStock' => '51', 'productPurchasePrice' => '220', 'profit_percent' => '6', 'productSalePrice' => '270', 'productWholeSalePrice' => '250', 'productDealerPrice' => '230', 'mfg_date' => '2025-07-28', 'expire_date' => '2025-08-06', 'created_at' => '2025-08-21 08:54:06', 'updated_at' => '2025-08-21 08:54:06'),
            array('business_id' => '1', 'product_id' => '5', 'batch_no' => NULL, 'productStock' => '300', 'productPurchasePrice' => '350', 'profit_percent' => '12', 'productSalePrice' => '392', 'productWholeSalePrice' => '330', 'productDealerPrice' => '340', 'mfg_date' => '2025-08-21', 'expire_date' => '2027-10-12', 'created_at' => '2025-08-21 08:57:47', 'updated_at' => '2025-08-21 08:57:47'),
            array('business_id' => '1', 'product_id' => '6', 'batch_no' => NULL, 'productStock' => '320', 'productPurchasePrice' => '319.725', 'profit_percent' => '15', 'productSalePrice' => '350.18', 'productWholeSalePrice' => '270', 'productDealerPrice' => '260', 'mfg_date' => '2025-08-21', 'expire_date' => '2027-07-14', 'created_at' => '2025-08-21 09:00:51', 'updated_at' => '2025-08-21 09:00:51'),
            array('business_id' => '1', 'product_id' => '7', 'batch_no' => NULL, 'productStock' => '234', 'productPurchasePrice' => '241.5', 'profit_percent' => '5', 'productSalePrice' => '253.57', 'productWholeSalePrice' => '230', 'productDealerPrice' => '230', 'mfg_date' => '2025-08-21', 'expire_date' => '2025-08-22', 'created_at' => '2025-08-21 09:04:20', 'updated_at' => '2025-08-21 09:04:20'),
            array('business_id' => '1', 'product_id' => '8', 'batch_no' => NULL, 'productStock' => '17', 'productPurchasePrice' => '156', 'profit_percent' => '7', 'productSalePrice' => '166.92', 'productWholeSalePrice' => '145', 'productDealerPrice' => '140', 'mfg_date' => '2025-08-21', 'expire_date' => '2025-09-06', 'created_at' => '2025-08-21 09:09:04', 'updated_at' => '2025-08-21 09:09:04')
        );

        Stock::insert($stocks);
    }
}

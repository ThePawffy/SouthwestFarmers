<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseDetails;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchases = array(
            array('party_id' => '4', 'business_id' => '1', 'user_id' => '4', 'discountAmount' => '19.166666666667', 'shipping_charge' => '45', 'discount_percent' => '0', 'discount_type' => 'flat', 'dueAmount' => '0', 'paidAmount' => '555.83333333333', 'change_amount' => '0', 'totalAmount' => '555.83333333333', 'invoiceNumber' => 'P-00001', 'isPaid' => '1', 'vat_amount' => '30.00', 'vat_id' => '1', 'paymentType' => NULL, 'payment_type_id' => '1', 'purchaseDate' => '2025-08-18 08:38:00', 'meta' => '{"note":null}', 'created_at' => '2025-08-18 08:40:52', 'updated_at' => '2025-08-18 08:44:57'),
            array('party_id' => '5', 'business_id' => '1', 'user_id' => '4', 'discountAmount' => '105', 'shipping_charge' => '70', 'discount_percent' => '5', 'discount_type' => 'percent', 'dueAmount' => '685', 'paidAmount' => '1021', 'change_amount' => '0', 'totalAmount' => '2085', 'invoiceNumber' => 'P-00002', 'isPaid' => '0', 'vat_amount' => '120.00', 'vat_id' => '2', 'paymentType' => NULL, 'payment_type_id' => '2', 'purchaseDate' => '2025-08-18 08:41:00', 'meta' => '{"note":null}', 'created_at' => '2025-08-18 08:42:14', 'updated_at' => '2025-08-18 08:45:23'),
            array('party_id' => '6', 'business_id' => '1', 'user_id' => '4', 'discountAmount' => '15.294117647059', 'shipping_charge' => '230', 'discount_percent' => '0', 'discount_type' => 'flat', 'dueAmount' => '3261.7058823529', 'paidAmount' => '0', 'change_amount' => '0', 'totalAmount' => '3261.7058823529', 'invoiceNumber' => 'P-00003', 'isPaid' => '0', 'vat_amount' => '187.00', 'vat_id' => '2', 'paymentType' => NULL, 'payment_type_id' => '4', 'purchaseDate' => '2025-08-18 08:42:00', 'meta' => '{"note":null}', 'created_at' => '2025-08-18 08:44:40', 'updated_at' => '2025-08-18 08:45:42')
        );

        Purchase::insert($purchases);

        $purchase_details = array(
            array('purchase_id' => '1', 'product_id' => '1', 'productDealerPrice' => '150', 'productPurchasePrice' => '100', 'productSalePrice' => '200', 'productWholeSalePrice' => '180', 'dealer_price' => '0', 'quantities' => '5.00', 'expire_date' => '2027-06-19', 'mfg_date' => NULL, 'profit_percent' => NULL, 'stock_id' => '5'),
            array('purchase_id' => '2', 'product_id' => '2', 'productDealerPrice' => '220', 'productPurchasePrice' => '200', 'productSalePrice' => '300', 'productWholeSalePrice' => '250', 'dealer_price' => '0', 'quantities' => '10.00', 'expire_date' => '2029-10-23', 'mfg_date' => NULL, 'profit_percent' => NULL, 'stock_id' => '6'),
            array('purchase_id' => '3', 'product_id' => '4', 'productDealerPrice' => '230', 'productPurchasePrice' => '220', 'productSalePrice' => '270', 'productWholeSalePrice' => '250', 'dealer_price' => '0', 'quantities' => '13.00', 'expire_date' => '2030-07-31', 'mfg_date' => NULL, 'profit_percent' => NULL, 'stock_id' => '7')
        );

        PurchaseDetails::insert($purchase_details);
    }
}

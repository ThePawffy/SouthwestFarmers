<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleDetails;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = array(
            array('business_id' => '1', 'party_id' => NULL, 'user_id' => '4', 'type' => 'sale', 'discountAmount' => '20', 'shipping_charge' => '80', 'discount_percent' => '0', 'discount_type' => 'flat', 'dueAmount' => '0', 'isPaid' => '1', 'vat_amount' => '30', 'vat_percent' => '0', 'paidAmount' => '490', 'change_amount' => '0', 'totalAmount' => '490', 'actual_total_amount' => '490.00', 'rounding_amount' => '0.00', 'rounding_option' => 'none', 'lossProfit' => '180', 'paymentType' => NULL, 'payment_type_id' => '1', 'invoiceNumber' => 'S-00001', 'saleDate' => '2025-08-18 08:46:00', 'image' => NULL, 'meta' => '{"customer_phone":null,"note":null}', 'created_at' => '2025-08-18 08:47:57', 'updated_at' => '2025-08-18 08:52:24', 'vat_id' => '2'),
            array('business_id' => '1', 'party_id' => NULL, 'user_id' => '4', 'type' => 'sale', 'discountAmount' => '44.1', 'shipping_charge' => '90', 'discount_percent' => '7', 'discount_type' => 'percent', 'dueAmount' => '290.9', 'isPaid' => '0', 'vat_amount' => '45', 'vat_percent' => '0', 'paidAmount' => '122.05', 'change_amount' => '0', 'totalAmount' => '690.9', 'actual_total_amount' => '690.90', 'rounding_amount' => '0.00', 'rounding_option' => 'none', 'lossProfit' => '155.9', 'paymentType' => NULL, 'payment_type_id' => '2', 'invoiceNumber' => 'S-00002', 'saleDate' => '2025-08-18 08:48:00', 'image' => NULL, 'meta' => '{"customer_phone":null,"note":null}', 'created_at' => '2025-08-18 08:49:10', 'updated_at' => '2025-08-18 08:52:44', 'vat_id' => '1'),
            array('business_id' => '1', 'party_id' => NULL, 'user_id' => '4', 'type' => 'sale', 'discountAmount' => '24', 'shipping_charge' => '120', 'discount_percent' => '0', 'discount_type' => 'flat', 'dueAmount' => '1581', 'isPaid' => '0', 'vat_amount' => '135', 'vat_percent' => '0', 'paidAmount' => '0', 'change_amount' => '0', 'totalAmount' => '1581', 'actual_total_amount' => '1581.00', 'rounding_amount' => '0.00', 'rounding_option' => 'none', 'lossProfit' => '226', 'paymentType' => NULL, 'payment_type_id' => '3', 'invoiceNumber' => 'S-00003', 'saleDate' => '2025-08-18 08:49:00', 'image' => NULL, 'meta' => '{"customer_phone":null,"note":null}', 'created_at' => '2025-08-18 08:49:53', 'updated_at' => '2025-08-18 08:49:53', 'vat_id' => '3'),
            array('business_id' => '1', 'party_id' => '1', 'user_id' => '4', 'type' => 'sale', 'discountAmount' => '189', 'shipping_charge' => '75', 'discount_percent' => '10', 'discount_type' => 'percent', 'dueAmount' => '161', 'isPaid' => '0', 'vat_amount' => '135', 'vat_percent' => '0', 'paidAmount' => '854.5', 'change_amount' => '0', 'totalAmount' => '1821', 'actual_total_amount' => '1821.00', 'rounding_amount' => '0.00', 'rounding_option' => 'none', 'lossProfit' => '1511', 'paymentType' => NULL, 'payment_type_id' => '4', 'invoiceNumber' => 'S-00004', 'saleDate' => '2025-08-18 08:51:00', 'image' => NULL, 'meta' => '{"customer_phone":null,"note":null}', 'created_at' => '2025-08-18 08:52:04', 'updated_at' => '2025-08-18 08:52:56', 'vat_id' => '1')
        );

        Sale::insert($sales);

        $sale_details = array(
            array('sale_id' => '1', 'product_id' => '1', 'price' => '200', 'lossProfit' => '180', 'quantities' => '2.00', 'productPurchasePrice' => '100', 'mfg_date' => NULL, 'expire_date' => '2027-06-19', 'stock_id' => '5'),
            array('sale_id' => '2', 'product_id' => '2', 'price' => '300', 'lossProfit' => '155.9', 'quantities' => '2.00', 'productPurchasePrice' => '200', 'mfg_date' => NULL, 'expire_date' => NULL, 'stock_id' => '2'),
            array('sale_id' => '3', 'product_id' => '4', 'price' => '270', 'lossProfit' => '226', 'quantities' => '5.00', 'productPurchasePrice' => '220', 'mfg_date' => NULL, 'expire_date' => '2025-08-06', 'stock_id' => '4'),
            array('sale_id' => '4', 'product_id' => '3', 'price' => '900', 'lossProfit' => '1511', 'quantities' => '2.00', 'productPurchasePrice' => '50', 'mfg_date' => NULL, 'expire_date' => '2025-08-09', 'stock_id' => '3')
        );

        SaleDetails::insert($sale_details);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Party;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Purchase;
use App\Models\SaleReturn;
use App\Models\SaleDetails;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\PurchaseDetails;
use Illuminate\Database\Seeder;
use App\Models\SaleReturnDetails;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $current_date = now();
        $expire_date = now()->addDays(30);

        $suppliers = array(
            array('name' => 'Raju Sekh', 'business_id' => '1', 'email' => 'raju@gmail.com', 'type' => 'Supplier', 'phone' => '01578239023', 'due' => '100', 'address' => 'Bhola', 'image' => 'uploads/25/05/1748430254-833.jpeg', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('name' => 'Alok Uddin', 'business_id' => '1', 'email' => 'alok@gmail.com', 'type' => 'Supplier', 'phone' => '0183536434', 'due' => '250', 'address' => 'Barisal', 'image' => 'uploads/25/05/1748430265-243.jpeg', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('name' => 'Fimi Hossein', 'business_id' => '1', 'email' => 'rimi@gmail.com', 'type' => 'Supplier', 'phone' => '01587238935', 'due' => '280', 'address' => 'Gabtoli', 'image' => 'uploads/25/05/1748430276-965.jpeg', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        $customers = array(
            array('name' => 'Shihab Uddin', 'business_id' => '1', 'email' => 'shihab@gmail.com', 'type' => 'Dealer', 'phone' => '01354892146', 'due' => '700', 'address' => 'Dhaka', 'image' => 'uploads/25/05/1748430556-689.jpeg', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('name' => 'Rohim Shah', 'business_id' => '1', 'email' => 'rohim@gmail.com', 'type' => 'Retailer', 'phone' => '01789238420', 'due' => '300', 'address' => 'Bogra', 'image' => 'uploads/25/05/1748430546-256.jpeg', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('name' => 'Rita Rahman', 'business_id' => '1', 'email' => 'rita@gmail.com', 'type' => 'Wholesaler', 'phone' => '01678230921', 'due' => '200', 'address' => 'Khulna', 'image' => 'uploads/25/05/1748430530-747.jpeg', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        $sales = array(
            array('business_id' => '1', 'user_id' => '4', 'type' => 'sale', 'discountAmount' => '44.1', 'shipping_charge' => '90', 'discount_percent' => '7', 'discount_type' => 'percent', 'dueAmount' => '290.9', 'isPaid' => '0', 'vat_amount' => '45', 'vat_percent' => '0', 'paidAmount' => '122.05', 'change_amount' => '0', 'totalAmount' => '690.9', 'actual_total_amount' => '690.90', 'rounding_amount' => '0.00', 'rounding_option' => 'none', 'lossProfit' => '155.9', 'paymentType' => NULL, 'payment_type_id' => '2', 'invoiceNumber' => 'S-00002', 'saleDate' => '2025-08-18 08:48:00', 'image' => NULL, 'meta' => ['customer_phone' => null, 'note' => null], 'created_at' => $current_date, 'updated_at' => $current_date, 'vat_id' => '1'),
            array('business_id' => '1', 'user_id' => '4', 'type' => 'sale', 'discountAmount' => '24', 'shipping_charge' => '120', 'discount_percent' => '0', 'discount_type' => 'flat', 'dueAmount' => '1581', 'isPaid' => '0', 'vat_amount' => '135', 'vat_percent' => '0', 'paidAmount' => '0', 'change_amount' => '0', 'totalAmount' => '1581', 'actual_total_amount' => '1581.00', 'rounding_amount' => '0.00', 'rounding_option' => 'none', 'lossProfit' => '226', 'paymentType' => NULL, 'payment_type_id' => '3', 'invoiceNumber' => 'S-00003', 'saleDate' => '2025-08-18 08:49:00', 'image' => NULL, 'meta' => ['customer_phone' => null, 'note' => null], 'created_at' => $current_date, 'updated_at' => $current_date, 'vat_id' => '3'),
            array('business_id' => '1', 'user_id' => '4', 'type' => 'sale', 'discountAmount' => '189', 'shipping_charge' => '75', 'discount_percent' => '10', 'discount_type' => 'percent', 'dueAmount' => '161', 'isPaid' => '0', 'vat_amount' => '135', 'vat_percent' => '0', 'paidAmount' => '854.5', 'change_amount' => '0', 'totalAmount' => '1821', 'actual_total_amount' => '1821.00', 'rounding_amount' => '0.00', 'rounding_option' => 'none', 'lossProfit' => '1511', 'paymentType' => NULL, 'payment_type_id' => '4', 'invoiceNumber' => 'S-00004', 'saleDate' => '2025-08-18 08:51:00', 'image' => NULL, 'meta' => ['customer_phone' => null, 'note' => null], 'created_at' => $current_date, 'updated_at' => $current_date, 'vat_id' => '1'),
        );

        $sale_details = array(
            array('product_id' => '2', 'price' => '300', 'lossProfit' => '155.9', 'quantities' => '2.00', 'productPurchasePrice' => '200', 'mfg_date' => NULL, 'expire_date' => $expire_date, 'stock_id' => '2'),
            array('product_id' => '4', 'price' => '270', 'lossProfit' => '226', 'quantities' => '5.00', 'productPurchasePrice' => '220', 'mfg_date' => NULL, 'expire_date' => $expire_date, 'stock_id' => '4'),
            array('product_id' => '3', 'price' => '900', 'lossProfit' => '1511', 'quantities' => '2.00', 'productPurchasePrice' => '50', 'mfg_date' => NULL, 'expire_date' => $expire_date, 'stock_id' => '3'),
        );

        $sale_returns = array(
            array('business_id' => '1', 'invoice_no' => 'SR01', 'return_date' => '2025-08-18 08:52:24', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'invoice_no' => 'SR02', 'return_date' => '2025-08-18 08:52:44', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'invoice_no' => 'SR03', 'return_date' => '2025-08-18 08:52:56', 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        $sale_return_details = array(
            array('business_id' => '1', 'return_amount' => '190.00', 'return_qty' => '1'),
            array('business_id' => '1', 'return_amount' => '277.95', 'return_qty' => '1'),
            array('business_id' => '1', 'return_amount' => '805.50', 'return_qty' => '1'),
        );

        $purchases = array(
            array('business_id' => '1', 'user_id' => '4', 'discountAmount' => '19.166666666667', 'shipping_charge' => '45', 'discount_percent' => '0', 'discount_type' => 'flat', 'dueAmount' => '0', 'paidAmount' => '555.83333333333', 'change_amount' => '0', 'totalAmount' => '555.83333333333', 'invoiceNumber' => 'P-00001', 'isPaid' => '1', 'vat_amount' => '30.00', 'vat_id' => '1', 'paymentType' => NULL, 'payment_type_id' => '1', 'purchaseDate' => '2025-08-18 08:38:00', 'meta' => ['note' => null], 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'user_id' => '4', 'discountAmount' => '105', 'shipping_charge' => '70', 'discount_percent' => '5', 'discount_type' => 'percent', 'dueAmount' => '685', 'paidAmount' => '1021', 'change_amount' => '0', 'totalAmount' => '2085', 'invoiceNumber' => 'P-00002', 'isPaid' => '0', 'vat_amount' => '120.00', 'vat_id' => '2', 'paymentType' => NULL, 'payment_type_id' => '2', 'purchaseDate' => '2025-08-18 08:41:00', 'meta' => ['note' => null], 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'user_id' => '4', 'discountAmount' => '15.294117647059', 'shipping_charge' => '230', 'discount_percent' => '0', 'discount_type' => 'flat', 'dueAmount' => '3261.7058823529', 'paidAmount' => '0', 'change_amount' => '0', 'totalAmount' => '3261.7058823529', 'invoiceNumber' => 'P-00003', 'isPaid' => '0', 'vat_amount' => '187.00', 'vat_id' => '2', 'paymentType' => NULL, 'payment_type_id' => '4', 'purchaseDate' => '2025-08-18 08:42:00', 'meta' => ['note' => null], 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        $purchase_details = array(
            array('product_id' => '1', 'productDealerPrice' => '150', 'productPurchasePrice' => '100', 'productSalePrice' => '200', 'productWholeSalePrice' => '180', 'dealer_price' => '0', 'quantities' => '5.00', 'expire_date' => $expire_date, 'mfg_date' => NULL, 'profit_percent' => NULL, 'stock_id' => '5'),
            array('product_id' => '2', 'productDealerPrice' => '220', 'productPurchasePrice' => '200', 'productSalePrice' => '300', 'productWholeSalePrice' => '250', 'dealer_price' => '0', 'quantities' => '10.00', 'expire_date' => $expire_date, 'mfg_date' => NULL, 'profit_percent' => NULL, 'stock_id' => '6'),
            array('product_id' => '4', 'productDealerPrice' => '230', 'productPurchasePrice' => '220', 'productSalePrice' => '270', 'productWholeSalePrice' => '250', 'dealer_price' => '0', 'quantities' => '13.00', 'expire_date' => $expire_date, 'mfg_date' => NULL, 'profit_percent' => NULL, 'stock_id' => '7'),
        );

        foreach ($sales as $key => $sale) {

            $customer = Party::create($customers[$key]);
            $supplier = Party::create($suppliers[$key]);

            $sale_data = Sale::create($sale + [
                'party_id' => $customer->id
            ]);

            $sale_detail = SaleDetails::create($sale_details[$key] + [
                'sale_id' => $sale_data->id
            ]);

            $sale_return_data = SaleReturn::create($sale_returns[$key] + [
                'sale_id' => $sale_data->id
            ]);

            SaleReturnDetails::create($sale_return_details[$key] + [
                'sale_return_id' => $sale_return_data->id,
                'sale_detail_id' => $sale_detail->id
            ]);

            $purchase_data = Purchase::create($purchases[$key] + [
                'party_id' => $supplier->id
            ]);
            PurchaseDetails::create($purchase_details[$key] + [
                'purchase_id' => $purchase_data->id
            ]);
        }

        $expense_categories = array(
            array('categoryName' => 'Supplier', 'business_id' => '1', 'categoryDescription' => 'Supplier expense', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('categoryName' => 'Rent', 'business_id' => '1', 'categoryDescription' => 'All rent expense', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('categoryName' => 'Utility', 'business_id' => '1', 'categoryDescription' => 'Utility bills', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        $expenses = array(
            array('business_id' => '1', 'user_id' => '4', 'amount' => '4645', 'expenseFor' => 'Supplier', 'paymentType' => 'Card', 'referenceNo' => '463443', 'note' => 'all done', 'expenseDate' => '2005-08-11 00:00:00', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'user_id' => '4', 'amount' => '34345', 'expenseFor' => 'Rent', 'paymentType' => 'Cash', 'referenceNo' => '264453', 'note' => 'all ok', 'expenseDate' => '2005-08-11 00:00:00', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'user_id' => '4', 'amount' => '6896', 'expenseFor' => 'Utility Bills', 'paymentType' => 'Check', 'referenceNo' => '462342', 'note' => 'all success', 'expenseDate' => '2005-08-11 00:00:00', 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        foreach ($expense_categories as $key => $expense_category) {
            $expenses_category = ExpenseCategory::create($expense_category);
            Expense::create($expenses[$key] + [
                'expense_category_id' => $expenses_category->id
            ]);
        }

        $income_categories = array(
            array('categoryName' => 'Sales', 'business_id' => '1', 'categoryDescription' => 'All sales income', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('categoryName' => 'Delivery', 'business_id' => '1', 'categoryDescription' => 'Income for delivery', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('categoryName' => 'ReturnFee', 'business_id' => '1', 'categoryDescription' => 'Return fee income', 'status' => '1', 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        $incomes = array(
            array('business_id' => '1', 'user_id' => '4', 'amount' => '4645', 'incomeFor' => 'Sales', 'paymentType' => 'Card', 'referenceNo' => '343343', 'note' => 'all done', 'incomeDate' => '2005-08-11 00:00:00', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'user_id' => '4', 'amount' => '34345', 'incomeFor' => 'Delivery', 'paymentType' => 'Cash', 'referenceNo' => '264453', 'note' => 'all ok', 'incomeDate' => '2005-08-11 00:00:00', 'created_at' => $current_date, 'updated_at' => $current_date),
            array('business_id' => '1', 'user_id' => '4', 'amount' => '6896', 'incomeFor' => 'Return Fee', 'paymentType' => 'Check', 'referenceNo' => '462347', 'note' => 'all success', 'incomeDate' => '2005-08-11 00:00:00', 'created_at' => $current_date, 'updated_at' => $current_date),
        );

        foreach ($income_categories as $key => $income_category) {
            $incomes_category = IncomeCategory::create($income_category);
            Income::create($incomes[$key] + [
                'income_category_id' => $incomes_category->id
            ]);
        }
    }
}

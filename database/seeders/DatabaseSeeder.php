<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            BusinessCategorySeeder::class,
            BusinessSeeder::class,
            PermissionSeeder::class,
            OptionTableSeeder::class,
            UserSeeder::class,
            CurrencySeeder::class,
            OthersCurrenciesSeeder::class,
            GatewaySeeder::class,
            TapPaymentSeeder::class,
            AdvertiseSeeder::class,
            PlanSubscribeSeeder::class,
            VatSeeder::class,
            PaymentTypeSeeder::class,
            PartySeeder::class,
            IncomeCategorySeeder::class,
            IncomeSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseSeeder::class,
            UnitSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            FaqSeeder::class,
            TutorialSeeder::class,
            ProductSettingsSeeder::class,
            PurchaseSeeder::class,
            PurchaseReturnSeeder::class,
            SaleSeeder::class,
            SaleReturnSeeder::class,
            ProductModelSeeder::class
        ]);
    }
}

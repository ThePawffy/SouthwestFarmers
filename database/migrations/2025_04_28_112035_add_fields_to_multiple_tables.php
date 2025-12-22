<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parties', function (Blueprint $table) {
            $table->dropUnique('parties_phone_unique');
            $table->string('phone')->nullable()->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->double('alert_qty', 10, 2)->default(0)->after('productStock');
            $table->date('expire_date')->nullable()->after('productStock');
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['vat_id']);
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete();
            $table->foreign('vat_id')->references('id')->on('vats')->nullOnDelete();
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string('discount_type')->default('flat')->after('discountAmount'); // flat, percent
            $table->double('discount_percent')->default(0)->after('discountAmount');
            $table->double('shipping_charge')->default(0)->after('discountAmount');
            $table->string('image')->nullable()->after('saleDate');
            $table->string('rounding_option')->nullable()->after('totalAmount');
            $table->double('rounding_amount', 10, 2)->default(0)->after('totalAmount');
            $table->double('actual_total_amount', 10, 2)->default(0)->after('totalAmount');
            $table->double('change_amount')->default(0)->after('paidAmount');
        });
        Schema::table('sale_details', function (Blueprint $table) {
            $table->double('quantities', 10, 2)->default(0)->change();
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
            $table->foreignId('vat_id')->nullable()->after('isPaid');
            $table->foreign('vat_id')->references('id')->on('vats')->nullOnDelete();
            $table->double('vat_amount', 10, 2)->default(0)->after('isPaid');
            $table->string('discount_type')->default('flat')->after('discountAmount'); // flat, percent
            $table->double('discount_percent')->default(0)->after('discountAmount');
            $table->double('shipping_charge')->default(0)->after('discountAmount');
            $table->double('change_amount')->default(0)->after('paidAmount');
        });
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->double('dealer_price')->default(0)->after('productWholeSalePrice');

            $table->double('quantities', 10, 2)->default(0)->change();
        });

        Schema::table('due_collects', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
        });
        Schema::table('incomes', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parties', function (Blueprint $table) {
            $table->string('phone')->unique()->nullable()->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('alert_qty','expire_date');
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['vat_id']);
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
            $table->foreign('vat_id')->references('id')->on('vats')->cascadeOnDelete();
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['payment_type_id','discount_type', 'discount_percent', 'shipping_charge', 'image', 'rounding_option', 'rounding_amount', 'actual_total_amount','change_amount']);
        });
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn(['quantities']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->string("paymentType")->default("Cash")->change();
            $table->dropColumn(['payment_type_id','discount_type', 'discount_percent', 'shipping_charge','change_amount','vat_id','vat_amount']);
        });
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropColumn('dealer_price');
            $table->integer('quantities')->default(0)->change();;
        });
        Schema::table('due_collects', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
            $table->string("paymentType")->default("Cash")->change();
        });
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
            $table->string("paymentType")->default("Cash")->change();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
            $table->string("paymentType")->default("Cash")->change();
        });
    }
};

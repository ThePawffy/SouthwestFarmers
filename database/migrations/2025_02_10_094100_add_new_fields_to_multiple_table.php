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
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('vat_id')->nullable()->constrained()->nullOnDelete()->after('vat_percent');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('vat_id')->nullable()->constrained()->cascadeOnDelete()->after('productStock');
            $table->string('vat_type')->default('exclusive')->after('productStock');
            $table->double('vat_amount', 10, 2)->default(0)->after('productStock');
            $table->double('profit_percent')->default(0)->after('productStock');
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->string('vat_name')->nullable()->after('shopOpeningBalance');
            $table->string('vat_no')->nullable()->after('shopOpeningBalance');
        });
        
        Schema::table('brands', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('brandName');
            $table->text('description')->nullable()->after('icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('vat_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('vat_id');
            $table->dropColumn('vat_type');
            $table->dropColumn('vat_amount');
            $table->dropColumn('profit_percent');
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['vat_name', 'vat_no']);
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['icon', 'description']);
        });
    }
};

<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Vat;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ProductImport implements ToCollection
{
    protected $businessId;
    protected $categories = [];
    protected $brands = [];
    protected $units = [];
    protected $vats = [];
    protected $productsToInsert = [];
    protected $existingProductCodes = [];
    protected $excelProductCodes = [];

    public function __construct($businessId)
    {
        $this->businessId = $businessId;

        $this->existingProductCodes = Product::where('business_id', $businessId)
            ->pluck('productCode')
            ->toArray();
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // Skip the header

                // Read Excel fields
                $productName = trim($row[0]);
                $categoryName = trim($row[1]);
                $unitName = trim($row[2]);
                $brandName = trim($row[3]);
                $stock = $row[4] ?? 0;
                $productCode = trim($row[5]);
                $purchasePrice = $row[6] ?? 0;
                $salePrice = $row[7] ?? 0;
                $dealerPrice = $row[8] ?? $salePrice;
                $wholesalePrice = $row[9] ?? $salePrice;
                $vatName = trim($row[10]);
                $vatPercent = $row[11] ?? 0;
                $vatType = $row[12] ?? 'exclusive';
                $alertQty = $row[13] ?? 0;
                $manufacturer = $row[14] ?? null;
                $expireDate = $this->parseExcelDate($row[15]);

                if (!$productName || !$productCode || !$categoryName) {
                    continue; // Basic validation skip if empty
                }

                // Check duplicate product code inside database
                if (in_array($productCode, $this->existingProductCodes)) {
                    continue; // skip, already exists in DB
                }

                // Check duplicate product code inside Excel itself
                if (in_array($productCode, $this->excelProductCodes)) {
                    continue; // skip, duplicate inside Excel
                }

                $vat_amount = ($purchasePrice * ($vatPercent ?? 0)) / 100;
                $profitPercent = number_format((($salePrice - $purchasePrice) / $purchasePrice) * 100, 2);
                $grand_purchase_price = $vatType == 'inclusive' ? $purchasePrice + $vat_amount : $purchasePrice;

                // If passed, add to seen Excel codes
                $this->excelProductCodes[] = $productCode;

                // Fetch/Create Category
                if (!isset($this->categories[$categoryName])) {
                    $category = Category::firstOrCreate(
                        ['categoryName' => $categoryName, 'business_id' => $this->businessId],
                        ['categoryName' => $categoryName, 'business_id' => $this->businessId]
                    );
                    $this->categories[$categoryName] = $category->id;
                }

                // Fetch/Create Brand
                if (!isset($this->brands[$brandName])) {
                    $brand = Brand::firstOrCreate(
                        ['brandName' => $brandName, 'business_id' => $this->businessId],
                        ['brandName' => $brandName, 'business_id' => $this->businessId]
                    );
                    $this->brands[$brandName] = $brand->id;
                }

                // Fetch/Create Unit
                if (!isset($this->units[$unitName])) {
                    $unit = Unit::firstOrCreate(
                        ['unitName' => $unitName, 'business_id' => $this->businessId],
                        ['unitName' => $unitName, 'business_id' => $this->businessId]
                    );
                    $this->units[$unitName] = $unit->id;
                }

                // Fetch/Create Vat
                if (!isset($this->vats[$vatName])) {
                    $vat = Vat::firstOrCreate(
                        ['name' => $vatName, 'business_id' => $this->businessId],
                        ['name' => $vatName, 'rate' => 0, 'business_id' => $this->businessId]
                    );
                    $this->vats[$vatName] = $vat->id;
                }

                // Prepare data for bulk insert
                $this->productsToInsert[] = [
                    'productName' => $productName,
                    'business_id' => $this->businessId,
                    'unit_id' => $this->units[$unitName],
                    'brand_id' => $this->brands[$brandName],
                    'category_id' => $this->categories[$categoryName],
                    'productCode' => $productCode,
                    'productDealerPrice' => $dealerPrice,
                    'productPurchasePrice' => $grand_purchase_price,
                    'productSalePrice' => $salePrice,
                    'productWholeSalePrice' => $wholesalePrice,
                    'productStock' => $stock,
                    'vat_id' => $this->vats[$vatName],
                    'vat_type' => $vatType,
                    'vat_amount' => $vat_amount,
                    'profit_percent' => $profitPercent,
                    'alert_qty' => $alertQty,
                    'expire_date' => $expireDate,
                    'productManufacturer' => $manufacturer,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert in batches
                if (count($this->productsToInsert) >= 1000) {
                    Product::insert($this->productsToInsert);
                    $this->productsToInsert = [];
                }
            }

            // Insert remaining records
            if (!empty($this->productsToInsert)) {
                Product::insert($this->productsToInsert);
            }
        });
    }

    function parseExcelDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // If it is numeric (Excel timestamp)
        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Remove extra spaces
        $value = trim($value);

        // Try MM/DD/YYYY first
        try {
            return Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            // Try DD/MM/YYYY
            try {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Exception $e2) {
                // Try default parse (YYYY-MM-DD etc.)
                try {
                    return Carbon::parse($value)->format('Y-m-d');
                } catch (\Exception $e3) {
                    return null;
                }
            }
        }
    }
}

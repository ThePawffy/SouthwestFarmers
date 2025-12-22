<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use AgeekDev\Barcode\Facades\Barcode;
use AgeekDev\Barcode\Enums\Type;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BarcodeGeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barcode_types = array_map(
            fn($case) => ['value' => $case->value],
            Type::cases()
        );

        $products = Product::where('business_id', auth()->user()->business_id)->latest()->get();
        return view('businessAddon::barcode-generators.index', compact('products', 'barcode_types'));
    }

    public function fetchProducts(Request $request)
    {
        $products = Product::where('business_id', auth()->user()->business_id)
            ->when(!empty($request->search), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('productName', 'like', '%' . $request->search . '%')
                        ->orWhere('productCode', 'like', '%' . $request->search . '%');
                });
            }, function ($q) {
                $q->limit(5); // Limit 5 when search is empty
            })
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode_setting' => 'required|in:1,2,3',
        ]);

        $barcodeType = $request->input('barcode_type', Type::TYPE_CODE_128->value);
        $productIds = $request->input('product_ids', []);
        $quantities = $request->input('qty', []);
        $previewDates = $request->input('preview_date', []);
        $selectedVatType = $request->vat_type;

        if (empty($productIds)) {
            return response()->json(['message' => __('Please select at least one product.')], 400);
        }

        $generatedBarcodes = [];

        foreach ($productIds as $index => $productId) {
            $product = Product::find($productId);

            if (!$product) {
                continue; // Skip if product not found
            }

            $qty = $quantities[$index] ?? 1;
            $previewDate = $previewDates[$index] ?? null;
            // VAT Logic
            $basePrice = $product->productSalePrice ?? 0;
            $currentVatType = $product->vat_type;

            if ($request->product_price && $selectedVatType !== $currentVatType) {
                $vatRate = optional($product->vat)->rate ?? 0;

                if ($selectedVatType === 'inclusive') {
                    // Convert from exclusive to inclusive
                    $basePrice = $basePrice + (($vatRate / 100) * $basePrice);
                } elseif ($selectedVatType === 'exclusive') {
                    // Convert from inclusive to exclusive
                    $basePrice = $basePrice / (1 + ($vatRate / 100));
                }
            }

            $barcodeSvg = Barcode::imageType("png")
                ->type(Type::from($barcodeType))
                ->generate($product->productCode);

            for ($i = 0; $i < $qty; $i++) {

                $generatedBarcodes[] = [
                    'business_name' => $product->business->companyName ?? '',
                    'product_name' => $product->productName,
                    'product_code' => $product->productCode,
                    'product_price' => $basePrice,
                    'product_stock' => $product->productStock,
                    'packing_date' => $previewDate,
                    'barcode_svg' => $barcodeSvg,
                    'show_product_name' => $request->product_name,
                    'product_name_size' => $request->product_name_size,
                    'show_business_name' => $request->business_name,
                    'business_name_size' => $request->business_name_size,
                    'show_product_price' => $request->product_price,
                    'product_price_size' => $request->product_price_size,
                    'show_product_code' => $request->product_code,
                    'product_code_size' => $request->product_code_size,
                    'show_pack_date' => $request->pack_date,
                    'pack_date_size' => $request->pack_date_size,
                ];
            }
        }

        session(['generatedBarcodes' => $generatedBarcodes]);
        session()->put('printer', $request->barcode_setting);

        return response()->json([
            'redirect'  => route('business.barcodes.index'),
            'secondary_redirect_url'  => route('business.barcodes.preview'),
        ]);
    }

    public function preview()
    {
        $printer = session('printer');
        $generatedBarcodes = session('generatedBarcodes');

        session()->forget('printer');
        session()->forget('generatedBarcodes');

        return view('businessAddon::barcode-generators.print', compact('generatedBarcodes','printer'));
    }
}

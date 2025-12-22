<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Models\Option;
use App\Models\Business;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Models\ProductSetting;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    use HasUploader;

    public function index()
    {
        $setting = Option::where('key', 'business-settings')
                            ->whereJsonContains('value->business_id', auth()->user()->business_id)
                            ->first();
        $business_categories = BusinessCategory::whereStatus(1)->latest()->get();
        $business = Business::findOrFail(auth()->user()->business_id);

        return view('businessAddon::settings.general',compact('setting', 'business_categories', 'business'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'business_category_id' => 'required|exists:business_categories,id',
            'phoneNumber' => 'nullable', 'min:5', 'max:15',
            'vat_name' => 'nullable|max:250',
            'vat_no' => 'nullable|max:250|required_with:vat_name',
            'invoice_logo' => 'nullable|image',
            'invoice_scanner_logo' => 'nullable|image',
            'sale_rounding_option' => 'nullable|in:none,round_up,nearest_whole_number,nearest_0.05,nearest_0.1,nearest_0.5',
            'note' => 'nullable|string|max:250',
            'gratitude_message' => 'nullable|string|max:250'
        ]);

        DB::beginTransaction();

        try {
            $business = Business::findOrFail(auth()->user()->business_id);

            $business->update([
                'address' => $request->address,
                'companyName' => $request->companyName,
                'business_category_id' => $request->business_category_id,
                'phoneNumber' => $request->phoneNumber,
                'vat_name' => $request->vat_name,
                'vat_no' => $request->vat_no,
            ]);

            $data = $request->except('_token', '_method', 'logo', 'favicon', 'invoice_logo', 'invoice_scanner_logo', 'address', 'companyName', 'business_category_id', 'phoneNumber');

            $setting = Option::find($id);

            if ($setting) {
                $setting->update($request->except($data) + [
                        'value' => $request->except('_token', '_method', 'invoice_logo', 'invoice_scanner_logo', 'address', 'companyName', 'business_category_id', 'phoneNumber') + [
                                'business_id' => $business->id,
                                'invoice_logo' => $request->invoice_logo ? $this->upload($request, 'invoice_logo', $setting->value['invoice_logo'] ?? null) : ($setting->value['invoice_logo'] ?? null),
                                'invoice_scanner_logo' => $request->invoice_scanner_logo ? $this->upload($request, 'invoice_scanner_logo', $setting->value['invoice_scanner_logo'] ?? null) : ($setting->value['invoice_scanner_logo'] ?? null),
                                'note' => $request->note,
                                'gratitude_message' => $request->gratitude_message,
                                'sale_rounding_option' => $request->sale_rounding_option ?? 'none',
                                'address' => $request->address ?? '',
                                'vat_no' => $request->vat_no,
                            ],
                    ]);
            } else {
                Option::insert([
                    'key' => 'business-settings',
                    'value' => json_encode([
                        'business_id' => $business->id,
                        'invoice_logo' => $request->invoice_logo ? $this->upload($request, 'invoice_logo') : null,
                        'invoice_scanner_logo' => $request->invoice_scanner_logo ? $this->upload($request, 'invoice_scanner_logo') : null,
                        'note' => $request->note,
                        'gratitude_message' => $request->gratitude_message,
                        'sale_rounding_option' => $request->sale_rounding_option ?? 'none',
                        'address' => $request->address,
                        'vat_no' => $request->vat_no,
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Cache::forget("business_setting_{$business->id}");
            Cache::forget("business_sale_rounding_{$business->id}");

            DB::commit();

            return response()->json([
                'message' => __('Business General Setting updated successfully'),
                'redirect' => route('business.settings.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }
    }

    public function invoiceIndex()
    {
        $invoiceSettingKey = 'invoice_setting_' . auth()->user()->business_id;
        $invoice_setting = Option::where('key', $invoiceSettingKey)->first();
        return view('businessAddon::settings.invoice',compact('invoice_setting'));
    }

    public function updateInvoice(Request $request)
    {
        $request->validate([
            'invoice_size' => 'required|string|max:100|in:a4,3_inch_80mm',
        ]);

        $key = 'invoice_setting_' . auth()->user()->business_id;

        Option::updateOrCreate(
            ['key' => $key],
            ['value' => $request->invoice_size]
        );

        Cache::forget($key);

        return response()->json(__('Invoice setting updated successfully.'));
    }


    public function productIndex()
    {
        $product_setting = ProductSetting::where('business_id', auth()->user()->business_id)->first();
        return view('businessAddon::settings.product', compact('product_setting'));
    }


    public function updateProductSetting(Request $request)
    {
        $request->validate([
            'show_product_price' => 'nullable|boolean',
            'show_product_code' => 'nullable|boolean',
            'show_product_stock' => 'nullable|boolean',
            'show_product_sale_price' => 'nullable|boolean',
            'show_product_dealer_price' => 'nullable|boolean',
            'show_product_wholesale_price' => 'nullable|boolean',
            'show_product_unit' => 'nullable|boolean',
            'show_product_brand' => 'nullable|boolean',
            'show_product_category' => 'nullable|boolean',
            'show_product_manufacturer' => 'nullable|boolean',
            'show_product_image' => 'nullable|boolean',
            'show_expire_date' => 'nullable|boolean',
            'show_alert_qty' => 'nullable|boolean',
            'show_vat_id' => 'nullable|boolean',
            'show_vat_type' => 'nullable|boolean',
            'show_exclusive_price' => 'nullable|boolean',
            'show_inclusive_price' => 'nullable|boolean',
            'show_profit_percent' => 'nullable|boolean',
            'show_capacity' => 'nullable|boolean',
            'show_weight' => 'nullable|boolean',
            'show_color' => 'nullable|boolean',
            'show_size' => 'nullable|boolean',
            'show_type' => 'nullable|boolean',
            'show_batch_no' => 'nullable|boolean',
            'show_mfg_date' => 'nullable|boolean',
            'show_model_no' => 'nullable|boolean',
            'show_product_batch_no' => 'nullable|boolean',
            'show_product_expire_date' => 'nullable|boolean',
            'default_batch_no' => 'nullable|string|max:255',
            'default_expired_date' => 'nullable|date',
            'default_mfg_date' => 'nullable|date',
            'default_sale_price' => 'nullable|numeric|min:0',
            'default_wholesale_price' => 'nullable|numeric|min:0',
            'default_dealer_price' => 'nullable|numeric|min:0',
            'expire_date_type' => 'nullable|in:dmy,my',
            'mfg_date_type' => 'nullable|in:dmy,my',
            'show_product_type_single' => 'nullable|boolean',
            'show_product_type_variant' => 'nullable|boolean',
            'show_warehouse' => 'nullable|boolean',
            'show_action' => 'nullable|boolean',
        ]);

        if (
            !$request->boolean('show_product_type_single') &&
            !$request->boolean('show_product_type_variant')
        ) {
            throw ValidationException::withMessages([
                'product_type' => ['At least one product type must be selected: Single or Variant.'],
            ]);
        }

        $modules = $request->except([
            '_token',
            '_method',
            'default_expired_date_dmy',
            'default_expired_date_my',
            'default_mfg_date_dmy',
            'default_mfg_date_my',
        ]);

        // Set default_expired_date based on date type
        $modules['default_expired_date'] = $request->expire_date_type === 'dmy'
            ? $request->default_expired_date_dmy
            : ($request->expire_date_type === 'my'
                ? $request->default_expired_date_my
                : null);

        // Set default_mfg_date based on date type
        $modules['default_mfg_date'] = $request->mfg_date_type === 'dmy'
            ? $request->default_mfg_date_dmy
            : ($request->mfg_date_type === 'my'
                ? $request->default_mfg_date_my
                : null);

        $businessId = auth()->user()->business_id;

        ProductSetting::updateOrCreate(
            ['business_id' => $businessId],
            ['modules' => $modules]
        );

        Cache::forget('product_setting_' . $businessId);

        return response()->json(__('Product setting updated successfully.'));
    }
}


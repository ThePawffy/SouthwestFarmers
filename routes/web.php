<?php

use App\Http\Controllers as Web;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

Route::get('/payments-gateways/{plan_id}/{business_id}', [Web\PaymentController::class, 'index'])->name('payments-gateways.index');
Route::post('/payments/{plan_id}/{gateway_id}', [Web\PaymentController::class, 'payment'])->name('payments-gateways.payment');
Route::get('/payment/success', [Web\PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [Web\PaymentController::class, 'failed'])->name('payment.failed');
Route::post('ssl-commerz/payment/success', [Web\PaymentController::class, 'sslCommerzSuccess']);
Route::post('ssl-commerz/payment/failed', [Web\PaymentController::class, 'sslCommerzFailed']);
Route::get('/order-status', [Web\PaymentController::class, 'orderStatus'])->name('order.status');

Route::group([
    'namespace' => 'App\Library',
], function () {
    Route::get('/payment/paypal', 'Paypal@status');
    Route::get('/payment/mollie', 'Mollie@status');
    Route::post('/payment/paystack', 'Paystack@status')->name('paystack.status');
    Route::get('/paystack', 'Paystack@view')->name('paystack.view');
    Route::get('/razorpay/payment', 'Razorpay@view')->name('razorpay.view');
    Route::post('/razorpay/status', 'Razorpay@status');
    Route::get('/mercadopago/pay', 'Mercado@status')->name('mercadopago.status');
    Route::get('/payment/flutterwave', 'Flutterwave@status');
    Route::get('/payment/thawani', 'Thawani@status');
    Route::get('/payment/instamojo', 'Instamojo@status');
    Route::get('/payment/toyyibpay', 'Toyyibpay@status');
    Route::post('/phonepe/status', 'PhonePe@status')->name('phonepe.status');
    Route::post('/paytm/status', 'Paytm@status')->name('paytm.status');
    Route::get('/tap-payment/status', 'TapPayment@status')->name('tap-payment.status');
});

Route::get('/demo-reset', function () {
    Artisan::call('demo:reset');
    return Artisan::output();
});

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return back()->with('success', __('Cache has been cleared.'));
});

Route::get('/reset-data', function () {
    Artisan::call('migrate:fresh --seed');
    Artisan::call('module:seed Landing');

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return 'success';
});

Route::get('/update', function () {
    Artisan::call('migrate');

    if (file_exists(base_path('storage/installed'))) {
        touch(base_path('vendor/autoload1.php'));
    }

    Artisan::call('module:publish Landing');
    Artisan::call('module:migrate Landing');
    Artisan::call('module:seed Landing');

    if (!PaymentType::exists()) {
        Artisan::call('db:seed', ['--class' => 'PaymentTypeSeeder']);
    }

    if (Schema::hasTable('stocks') && !Stock::exists()) {
        $products = Product::all();
        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'business_id' => $product->business_id,
                'product_id'  => $product->id,
                'expire_date' => $product->expire_date ?? null,
                'productStock' => $product->productStock,
                'profit_percent' => $product->profit_percent,
                'productDealerPrice' => $product->productDealerPrice,
                'productPurchasePrice' => $product->productPurchasePrice,
                'productSalePrice' => $product->productSalePrice,
                'productWholeSalePrice' => $product->productWholeSalePrice,
                'created_at'  => $product->created_at,
                'updated_at'  => $product->updated_at,
            ];
        }

        collect($data)->chunk(500)->each(function ($chunk) {
            Stock::insert($chunk->toArray());
        });
    }

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return redirect('/')->with('message', __('System updated successfully.'));
});

require __DIR__ . '/auth.php';

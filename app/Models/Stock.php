<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'product_id',
        'batch_no',
        'productStock',
        'productPurchasePrice',
        'profit_percent',
        'productSalePrice',
        'productWholeSalePrice',
        'productDealerPrice',
        'mfg_date',
        'expire_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'business_id' => 'integer',
        'product_id' => 'integer',
        'productStock' => 'double',
        'productPurchasePrice' => 'double',
        'profit_percent' => 'double',
        'productSalePrice' => 'double',
        'productWholeSalePrice' => 'double',
        'productDealerPrice' => 'double',
    ];
}

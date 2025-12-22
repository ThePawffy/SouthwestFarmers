<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PurchasePaymentType extends Pivot
{
    use HasFactory;

    protected $table = 'purchase_payment_types';

    protected $fillable = [
        'purchase_id',
        'payment_type_id',
        'amount',
        'ref_code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = PurchasePaymentType::where('purchase_id', $model->purchase_id)->count() + 1;
            $model->ref_code = "P-" . $id;
        });
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
}

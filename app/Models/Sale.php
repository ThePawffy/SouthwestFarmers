<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id',
        'party_id',
        'user_id',
        'vat_id',
        'discountAmount',
        'dueAmount',
        'isPaid',
        'vat_amount',
        'vat_percent',
        'paidAmount',
        'lossProfit',
        'totalAmount',
        'paymentType',
        'invoiceNumber',
        'saleDate',
        'meta',
        'discount_percent',
        'discount_type',
        'shipping_charge',
        'payment_type_id',
        'image',
        'rounding_option',
        'rounding_amount',
        'actual_total_amount',
        'change_amount',
        'type',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function party() : BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function saleReturns()
    {
        return $this->hasMany(SaleReturn::class, 'sale_id');
    }

    public function vat() : BelongsTo
    {
        return $this->belongsTo(Vat::class);
    }

    public function payment_type() : BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function dueCollect()
    {
        return $this->hasOne(DueCollect::class);
    }

    public function paymentTypes()
    {
        return $this->belongsToMany(PaymentType::class, 'sale_payment_types')
            ->withPivot('amount', 'ref_code')
            ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = Sale::where('business_id', auth()->user()?->business_id ?? 1)->count() + 1;
            $model->invoiceNumber = "S-" . str_pad($id, 5, '0', STR_PAD_LEFT);
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'business_id' => 'integer',
        'payment_type_id' => 'integer',
        'party_id' => 'integer',
        'user_id' => 'integer',
        'vat_id' => 'integer',
        'discountAmount' => 'double',
        'dueAmount' => 'double',
        'isPaid' => 'boolean',
        'vat_amount' => 'double',
        'vat_percent' => 'double',
        'paidAmount' => 'double',
        'change_amount' => 'double',
        'totalAmount' => 'double',
        'lossProfit' => 'double',
        'shipping_charge' => 'double',
        'rounding_amount' => 'double',
        'actual_total_amount' => 'double',
        'discount_percent' => 'double',
        'meta' => 'json',
    ];
}

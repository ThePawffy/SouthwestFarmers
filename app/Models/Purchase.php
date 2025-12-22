<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'party_id',
        'business_id',
        'user_id',
        'meta',
        'discountAmount',
        'shipping_charge',
        'discount_percent',
        'discount_type',
        'dueAmount',
        'paidAmount',
        'change_amount',
        'totalAmount',
        'invoiceNumber',
        'isPaid',
        'vat_amount',
        'vat_id',
        'paymentType',
        'payment_type_id',
        'purchaseDate',
    ];

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function party() : BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class, 'purchase_id');
    }

    public function payment_type() : BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function vat() : BelongsTo
    {
        return $this->belongsTo(Vat::class);
    }

    public function paymentTypes()
    {
        return $this->belongsToMany(PaymentType::class, 'purchase_payment_types')
            ->withPivot('amount', 'ref_code')
            ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = Purchase::where('business_id', auth()->user()?->business_id ?? 1)->count() + 1;
            $model->invoiceNumber = "P-" . str_pad($id, 5, '0', STR_PAD_LEFT);
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'json',
        'party_id' => 'integer',
        'payment_type_id' => 'integer',
        'business_id' => 'integer',
        'user_id' => 'integer',
        'vat_id' => 'integer',
        'isPaid' => 'boolean',
        'discountAmount' => 'double',
        'dueAmount' => 'double',
        'paidAmount' => 'double',
        'change_amount' => 'double',
        'totalAmount' => 'double',
        'vat_amount' => 'double',
        'discount_percent' => 'double',
        'shipping_charge' => 'double',
    ];
}

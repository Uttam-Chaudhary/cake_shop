<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'order_id',
        'method',
        'status',
        'payment_receipt',
    ];

    protected static function booted()
    {
        // 🔹 Delete old receipt when a new one is uploaded
        static::updating(function (Payment $payment) {
            $original = $payment->getOriginal('payment_receipt');
            $new = $payment->payment_receipt;

            // If receipt path changed, delete old file
            if ($original && $original !== $new && Storage::disk('public')->exists($original)) {
                Storage::disk('public')->delete($original);
            }
        });

        // 🔹 Delete receipt when the payment record is deleted
        static::deleting(function (Payment $payment) {
            if ($payment->payment_receipt && Storage::disk('public')->exists($payment->payment_receipt)) {
                Storage::disk('public')->delete($payment->payment_receipt);
            }
        });

        // If using SoftDeletes, move the logic to forceDeleted() instead
        // static::forceDeleted(function (Payment $payment) { ... });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

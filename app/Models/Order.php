<?php

namespace App\Models;

use App\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public $fillable = [
        "customer_id",
        "order_code",
        "ordered_at",
        "status",
        "subtotal",
        "discount_total",
        "tax_total",
        "total_price",
    ];

    public $casts = [
        "status" => OrderStatus::class,
        "ordered_at" => "date",
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function booted(): void
    {
        self::creating(function (Order $order) {
            $order->status = OrderStatus::new->value;
        });
        self::created(function (Order $order) {
            $number = (string) $order->id;
            if (strlen($number) < 5) {
                $addZero = "";
                for ($i = $number; $i <= 5; $i++) {
                    $addZero .= "0";
                }
                $order->order_code = "DH" . $addZero . $order->id;
            } else {
                $order->order_code = "DH" . $order->id;
            }
            $order->saveQuietly();
        });
    }
}

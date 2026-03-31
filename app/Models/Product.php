<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    public $fillable = [
        "name",
        "category_id",
        "sku",
        "description",
        "price",
        "image",
    ];

    /**
     * Get all of the order items for the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, OrderItem::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function booted(): void
    {
        self::created(function (Product $product) {
            if ($product->sku == "") {
                $product->sku = "SP" . $product->id;
                $product->saveQuietly();
            }
        });
    }
}

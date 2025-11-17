<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['name', 'weights'];

    protected $casts = [
        "images" => "array",
        "weights" => "array"
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function flavours(): BelongsToMany
    {
        return $this->belongsToMany(Flavour::class, 'product_flavour')->withTimestamps();
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    protected static function booted()
    {
        static::deleting(function (Product $product) {
            // If using soft deletes, only remove files on forceDelete:
            if (method_exists($product, 'isForceDeleting') && ! $product->isForceDeleting()) {
                return;
            }

            // Delete each stored image path (assuming paths are relative to disk root)
            if ($product->images) {
                foreach ((array) $product->images as $path) {
                    if ($path && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        });

        // When updating, delete any images that are present in the original DB value
        // but not in the new images array.
        static::updating(function (Product $product) {
            // Get original images (raw DB value). Could be JSON string or array depending on context.
            $original = $product->getOriginal('images');

            // Normalize original images to array
            if (is_string($original)) {
                $originalImages = json_decode($original, true) ?: [];
            } elseif (is_array($original)) {
                $originalImages = $original;
            } else {
                $originalImages = [];
            }

            // New images - after casts this should be an array (or null)
            $newImages = $product->images ?? [];

            // Ensure both are arrays
            $originalImages = array_values(array_filter((array) $originalImages));
            $newImages = array_values(array_filter((array) $newImages));

            // Images to delete = present in original, not present in new
            $toDelete = array_diff($originalImages, $newImages);

            foreach ($toDelete as $path) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        });
    }
}

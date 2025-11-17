<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'heading',
        'logo',
        'banner',
        'description',
        'shop_id',
    ];
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    protected static function booted()
    {
        static::deleting(function ($category) {
            // Delete logo if exists
            if ($category->logo && Storage::disk('public')->exists($category->logo)) {
                Storage::disk('public')->delete($category->logo);
            }

            // Delete banner if exists
            if ($category->banner && Storage::disk('public')->exists($category->banner)) {
                Storage::disk('public')->delete($category->banner);
            }
        });

        // When updating, remove files that are being replaced
        static::updating(function (Category $category) {
            $original = $category->getOriginal();

            // Logo changed?
            if (
                isset($original['logo']) &&
                $original['logo'] &&
                array_key_exists('logo', $category->getAttributes()) &&
                $original['logo'] !== $category->logo
            ) {
                if (Storage::disk('public')->exists($original['logo'])) {
                    Storage::disk('public')->delete($original['logo']);
                }
            }

            // Banner changed?
            if (
                isset($original['banner']) &&
                $original['banner'] &&
                array_key_exists('banner', $category->getAttributes()) &&
                $original['banner'] !== $category->banner
            ) {
                if (Storage::disk('public')->exists($original['banner'])) {
                    Storage::disk('public')->delete($original['banner']);
                }
            }
        });
    }
}

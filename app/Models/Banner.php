<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = ['title', 'url', 'image', 'status'];

    protected static function booted()
    {
        static::deleting(function (Banner $banner) {
            // Skip if image column is null or empty
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
        });

        // When updating, remove files that are being replaced
        static::updating(function (Banner $banner) {
            $original = $banner->getOriginal();

            // Image changed?
            if (
                isset($original['image']) &&
                $original['image'] &&
                array_key_exists('image', $banner->getAttributes()) &&
                $original['image'] !== $banner->image
            ) {
                if (Storage::disk('public')->exists($original['image'])) {
                    Storage::disk('public')->delete($original['image']);
                }
            }
        });
    }
}

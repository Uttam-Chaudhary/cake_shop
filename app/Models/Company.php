<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'logo',
        'terms',
        'policy',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($company) {
            // Check if logo exists and delete from storage
            if ($company->logo && Storage::exists($company->logo)) {
                Storage::delete($company->logo);
            }
        });

        static::updated(function ($company) {
            $original = $company->getOriginal();

            // Photo changed?
            if (
                isset($original['logo']) &&
                $original['logo'] &&
                array_key_exists('logo', $company->getAttributes()) &&
                $original['logo'] !== $company->logo
            ) {
                if (Storage::disk('public')->exists($original['logo'])) {
                    Storage::disk('public')->delete($original['logo']);
                }
            }
        });
    }
}

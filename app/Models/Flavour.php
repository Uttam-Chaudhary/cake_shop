<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Flavour extends Model
{
  protected $fillable = ['name'];
     public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_flavour') ->withTimestamps();
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Shop extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'photo',
        'status',
        'expire_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     protected static function booted()
    {
        static::deleting(function (Shop $shop) {
            // If photo column contains a path (e.g. 'shops/photos/abc.jpg')
            if ($shop->photo && Storage::disk('public')->exists($shop->photo)) {
                Storage::disk('public')->delete($shop->photo);
            }
        });

        // When updating, remove files that are being replaced
        static::updating(function (Shop $shop) {
            $original = $shop->getOriginal();

            // Photo changed?
            if (
                isset($original['photo']) &&
                $original['photo'] &&
                array_key_exists('photo', $shop->getAttributes()) &&
                $original['photo'] !== $shop->photo
            ) {
                if (Storage::disk('public')->exists($original['photo'])) {
                    Storage::disk('public')->delete($original['photo']);
                }
            }
        });
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function flavours(): HasMany
    {
        return $this->hasMany(Flavour::class);
    }
    public function deliveries(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}

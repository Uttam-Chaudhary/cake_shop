<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\LocationController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/carts", [CartController::class, 'index'])->name("cart.index");
    Route::post("/cart/store/{id}", [CartController::class, 'store'])->name("cart.store");
    Route::patch("/cart/update/{id}", [CartController::class, 'update_qty'])->name("cart.update");
    Route::delete("/cart/delete/{id}", [CartController::class, 'destroy'])->name("cart.destroy");

    Route::get('/cart/{id}/edit', [CartController::class, 'edit'])->name('cart.edit');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post("/checkout/buyNow/{id}", [CartController::class, 'buyNow'])->name("checkout.buyNow");

    Route::get("/orders", [OrderController::class, 'index'])->name("order");
    Route::post('/checkout/select', [OrderController::class, 'select'])->name('checkout.select');
    Route::post("/order/store/{id}", [OrderController::class, 'store'])->name("order.store");

    Route::get('/get-delivery-fee/{id}', [LocationController::class, 'getDeliveryFee']);

    Route::post('/checkout/place', [OrderController::class, 'placeOrder'])->name('checkout.place');
    Route::get("/khalti/callback", [OrderController::class, 'khalti_callback'])->name("khalti.callback");
});

Route::get("/receipt/{id}", [PageController::class, 'receipt'])->name("receipt");
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get("/search", [PageController::class, 'search'])->name("search");
Route::post("/shop/store", [ShopController::class, 'store'])->name("shop.store");

require __DIR__ . '/auth.php';

// Login with google routes
Route::get('/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google_redirect');
Route::get('/callback', function () {
    $user = Socialite::driver('google')->user();
    $oldUser = User::where('email', $user->email)->first();
    if (!$oldUser) {
        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->getAvatar(), // Get the user's profile picture
            'password' => Hash::make(rand(1000, 9999)),
        ]);
        Auth::login($newUser);
        return redirect()->route('home');
    }
    Auth::login($oldUser);
    return redirect()->route('home');
});


Route::get('/{slug}', [PageController::class, 'category'])->name('category');
Route::get("/product/{id}", [PageController::class, 'product'])->name("product");

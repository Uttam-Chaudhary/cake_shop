<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Flavour;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseController
{
    public function index()
    {
        $carts = Cart::where("user_id", Auth::user()->id)->get();
        return view('frontend.carts', compact('carts'));
    }
    public function store(Request $request, $id)
    {
       $request->validate([
            'message'  => 'required|max:20|min:1',
            'flavour_id' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $Base_price =  $product->price / $product->weights[0]['weight'];
        $payable_amount = $Base_price * $request->weight;
        $amount = ($payable_amount - ($payable_amount * $product->discount_percentage) / 100);

        $cart = new Cart();
        $cart->qty = 1;
        $cart->message = $request->message;
        $cart->weight = $request->weight;
        $cart->flavour_id = $request->flavour_id;
        $cart->amount = $amount;
        $cart->product_id = $product->id;
        $cart->user_id = Auth::user()->id;
        $cart->save();
        toast("Product added to cart", 'success');
        return redirect()->route('home');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|max:10|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::user()->id)->findOrFail($id);
        $product = Product::findOrFail($cart->product_id);
        $Base_price =  $product->price / $product->weights[0]['weight'];
        $payable_amount = $Base_price * $cart->weight;
        $amount = ($payable_amount - ($payable_amount * $product->discount_percentage) / 100);

        $cart->qty = $request->qty;
        $cart->amount = $amount * $request->qty;
        $cart->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->findOrFail($id);
        $cart->delete();

        return response()->json(['success' => true]);
    }
}

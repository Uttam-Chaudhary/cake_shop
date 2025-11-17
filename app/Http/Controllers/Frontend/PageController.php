<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends BaseController
{
    public function home()
    {
        $products = Product::where('status', 1)->get();
        $categorys = Category::all();
        //  return $products;
        return view('frontend.home', compact('products', 'categorys'));
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $search = Product::where('name', 'like', "%$q%")->get();
        $products = $search->where('status', 1);
        return view('frontend.search', compact('products', 'q'));
    }
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $products = $category->products()->where('status', 1)->get();
        return view('frontend.category', compact('category', 'products'));
    }

    public function product($id)
    {
       // $product_find = Product::findOrFail($id);
        $product = Product::where('id', $id)->where('status', 1)->firstOrFail();

        if (!$product) {
            return view('frontend.404');
        }
        //  return $product;
        return view('frontend.product', compact('product'));
    }

    public function receipt($id)
    {
        $order = Order::where('order_id', $id)->first();
        $user = $order->user;
        $shop = Shop::findOrFail($order->shop_id);
        if ($shop || $user == Auth::guard('web')->user()) {
            return view('frontend.receipt', compact('order',  'shop'));
        }
        //  return view('frontend.404');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Product;

class PageController extends BaseController
{
    public function home()
    {
        return view('frontend.home');
    }
     public function category($slug){
        $category = Category::where('slug',$slug)->first();
        $products = $category->products()->get();
        return view('frontend.category', compact('category', 'products'));
    }

    public function product($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return view('frontend.404');
        }
      //  return $product;
        return view('frontend.product', compact('product'));
    }
}

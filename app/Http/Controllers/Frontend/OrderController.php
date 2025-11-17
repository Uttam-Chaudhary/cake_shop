<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class OrderController extends BaseController
{

    // public function placeOrder(Request $request)
    // {
    //     $request->validate([
    //         'selected_carts' => 'required|array|min:1',
    //         'selected_carts.*' => 'integer|distinct',
    //         'contact' => 'required|string|digits:10',
    //         'address' => 'required|string|max:255',
    //         'date' => 'required|date_format:Y-m-d',
    //         'payment_method' => 'required|string',
    //         'payment_receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    //         'transaction_id' => 'nullable|string',
    //     ]);

    //     $userId = Auth::user()->id;
    //     $cartIds = $request->input('selected_carts', []);

    //     $cartItems = Cart::with('product', 'product.shop')
    //         ->whereIn('id', $cartIds)
    //         ->where('user_id', $userId)
    //         ->get();


    //     // If QR payment, store the uploaded file ONE time and reuse the path.
    //     $storedReceiptPath = null;
    //     if ($request->payment_method === 'qr_payment') {
    //         if (!$request->hasFile('payment_receipt_image')) {
    //             return back()->withErrors(['payment_receipt_image' => 'Please upload QR payment receipt.']);
    //         }
    //         $file = $request->file('payment_receipt_image');
    //         if (!$file->isValid()) {
    //             return back()->withErrors(['payment_receipt_image' => 'Upload failed (code: ' . $file->getError() . ').']);
    //         }

    //         // store once on public disk (storage/app/public/payments/...)
    //         $storedReceiptPath = $file->store('payments', 'public'); // e.g. "payments/abc.jpg"
    //     }

    //     // Group by the shop id of the product
    //     $grouped = $cartItems->groupBy(function ($ci) {
    //         return $ci->product->shop_id; // or $ci->shop_id if you denormalized
    //     });
    //     $createdOrders = [];
    //     foreach ($grouped as $shopId => $items) {
    //         // compute total for this shop
    //         $total = $items->sum(function ($i) {
    //             return ($i->amount ?? $i->price); // prefer amount snapshot; adjust to your column names
    //         });

    //         $date = now()->format('Ymd');
    //         $random = strtoupper(Str::random(4));
    //         // create an order (adjust columns to your orders table)
    //         $order = Order::create([
    //             'user_id' => $userId,
    //             'shop_id' => $shopId,
    //             'status' => 'pending',
    //             'total_amount' => $total,
    //             'order_id' => "ORD-{$date}-{$random}",
    //             'contact' => $request->contact,
    //             'delivery_date' => $request->date,
    //             'delivery_address' => $request->address,

    //             // add additional fields if you have (shipping, payment_method, address_id, etc.)
    //         ]);

    //         // create order items
    //         foreach ($items as $ci) {
    //             $product = $ci->product;

    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $product->id,
    //                 'qty' => $ci->qty,
    //                 'weight' => $ci->weight,
    //                 'message' => $ci->message,
    //                 'flavour_id' => $ci->flavour_id,
    //                 'amount' => $ci->amount,
    //             ]);

    //             // remove the cart item
    //             //   $ci->delete();
    //         }

    //         $payment = new Payment();
    //         $payment->order_id = $order->id;
    //         $payment->method = $request->payment_method;
    //         if ($request->payment_method === 'qr_payment' && $storedReceiptPath) {
    //             // reuse the same stored path for each order
    //             $payment->payment_receipt = $storedReceiptPath;
    //             $payment->transaction_id = $request->transaction_id;
    //         }
    //         $payment->save();

    //         $createdOrders[] = $order->id;
    //     }

    //     if ($request->payment_method == 'khalti') {
    //         $response = Http::withHeaders([
    //             "Authorization" => "Key " . env("KHALTI_SECRET_KEY")
    //         ])->post("https://dev.khalti.com/api/v2/epayment/initiate/", [
    //             "return_url" => route('khalti.callback'),
    //             "website_url" => env("APP_URL"),
    //             "amount" => $request->total_amount * 100,
    //             "purchase_order_id" => $order->id,
    //             "purchase_order_name" => $order->shop->name,
    //         ]);

    //         if ($response["pidx"]) {
    //             return redirect($response["payment_url"]);
    //         }
    //     }

    //     toast("Your order has been placed", 'success');
    //     return redirect()->route('home');
    // }

    public function khalti_callback(Request $request)
    {
        $order = Order::findOrFail($request["purchase_order_id"]);
        $status = $request["status"];
        $payment = $order->payment;
        $payment->status = $status == "Completed" ? "paid" : $status;
        $payment->transaction_id = $request["transaction_id"];
        $payment->save();
        toast($request["status"], 'success');
        return redirect()->route('home');
    }

    public function index()
    {
        $orders = Order::where("user_id", Auth::user()->id)->get();
        return view('frontend.orders', compact('orders'));
    }

    public function buyNow(Request $request, $id)
    { {
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
            $cart->shop_id = $product->shop_id;
            $cart->user_id = Auth::user()->id;
            $cart->save();
            // toast("Product added to cart", 'success');
            return redirect()->route('cart.index');
        }
    }
    public function select(Request $request)
    {
        // Get selected cart IDs
        $selectedIds = $request->input('selected_carts', []);

        // If nothing selected, redirect back
        if (empty($selectedIds)) {
            toast("Please select at least one product form cart.", 'error');
            return back();
        }

        // Fetch only selected carts for this user
        $carts = Cart::whereIn('id', $selectedIds)
            ->where('user_id', Auth::user()->id)
            ->with('product.shop')
            ->get();
        $shop = $carts->first()->product->shop;
        $shopCarts = $carts->where('product.shop_id', $shop->id);
        $delivery_locations = Location::all();
        $locations = $delivery_locations->where('shop_id', $shop->id);
        // Redirect or show checkout view
        return view('frontend.checkout', compact('carts', 'shop', 'shopCarts', 'locations'));

        //   return view('frontend.multiple_order', compact('carts'));
    }


    public function store(Request $request, $id)
    {
        $request->validate([
            'location' => 'required',
            'contact' => 'required|string|digits:10',
            'address' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
        ]);
        // Get selected cart IDs
        $selectedIds = $request->input('selected_carts', []);

        // Fetch Shop using shop_id
        $shop = Shop::findOrFail($id);
        $location = Location::findOrfail($request->location);

        // Fetch only selected carts for this user
        $carts = Cart::whereIn('id', $selectedIds)
            ->where('user_id', Auth::user()->id)
            ->with('product.shop')
            ->get();

        $shopCarts = $carts->where('product.shop_id', $shop->id);

        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        $order = new Order();
        $order->order_id = "ORD-{$date}-{$random}";
        $order->shop_id = $shop->id;
        $order->user_id = Auth::user()->id;
        $order->total_amount = $shopCarts->sum('amount') + $location->fee;
        $order->location = $location->locality;
        $order->delivery_fee = $location->fee;
        $order->contact = $request->contact;
        $order->status = 'pending';
        $order->delivery_address = $request->address;
        $order->delivery_date = $request->date;
        $order->save();

        foreach ($shopCarts as $i => $cart) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cart->product_id;
            $orderItem->amount = $cart->amount;
            $orderItem->qty = $cart->qty;
            $orderItem->weight = $cart->weight;
            $orderItem->message = $cart->message;
            $orderItem->flavour_id = $cart->flavour_id;
            $orderItem->save();

            $cart->delete();
        }

        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->method = $request->payment_method;
        $payment->transaction_id = $request->transaction_id;

        if ($request->payment_method == 'qr_payment') {
            $file = $request->payment_receipt_image;
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('storage', $filename);
            $payment->payment_receipt = $filename;
        }

        $payment->save();

        if ($request->payment_method == 'khalti') {
            $response = Http::withHeaders([
                "Authorization" => "Key " . env("KHALTI_SECRET_KEY")
            ])->post("https://dev.khalti.com/api/v2/epayment/initiate/", [
                "return_url" => route('khalti.callback'),
                "website_url" => env("APP_URL"),
                "amount" => $order->total_amount * 100,
                "purchase_order_id" => $order->id,
                "purchase_order_name" => $order->shop->name,
            ]);

            if ($response["pidx"]) {
                return redirect($response["payment_url"]);
            }
        }

        toast("Your order has been placed", 'success');
        return redirect()->route('home');
    }
}

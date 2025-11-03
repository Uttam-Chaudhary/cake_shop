<x-frontend-layout title="home" description="this is meta description" keywords="this is meta keywords">
    <div class="container py-10">
        <h1 class="text-2xl font-bold text-[var(--primary)] mb-3">My Cart</h1>
        <form id="checkoutForm" action="{{ route('checkout.select') }}" method="POST">
            @csrf
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-8">
                    <div class=" p-3 bg-white border border-gray-200 shadow-sm">
                        <h2 class="text-xl text-red-500">SELECT ITEMS TO CHECKOUT</h2>
                    </div>

                    @if ($carts->isEmpty())
                        <div class="text-center py-16 bg-white rounded-lg shadow-md">
                            <p class="text-2xl text-[var(--text)] mb-4">Your cart is empty.</p>
                            <a href="{{ route('home') }}"
                                class="inline-block bg-[var(--primary)] text-white px-8 py-3 rounded-full hover:bg-opacity-80 transition duration-300 font-medium">
                                Shop Now
                            </a>
                        </div>
                    @else
                        @foreach ($carts->groupBy('product.shop_id') as $shopId => $shopCarts)
                            <h2 class="text-xl font-semibold text-[var(--primary)] ml-2 mt-2">
                                {{ $shopCarts->first()->product->shop->name }}
                            </h2>
                            @foreach ($shopCarts as $cart)
                                <div class="max-w-4xl mx-auto my-4">
                                    <div
                                        class="flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                        <!-- Left: checkbox -->
                                        <div class="flex-shrink-0">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="selected_carts[]"
                                                    value="{{ $cart->id }}"
                                                    class="cart-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300"
                                                    data-amount="{{ $cart->amount }}">
                                            </label>
                                        </div>

                                        <!-- Image -->
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset(Storage::url($cart->product->images[0])) }}"
                                                alt="Princess Sugarblush"
                                                class="w-20 h-20 object-cover rounded-md border" />
                                        </div>

                                        <!-- Middle: product info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 leading-tight">
                                                        {{ $cart->product->name }}</h3>

                                                    <div class="mt-2 text-gray-600 text-sm space-y-0">
                                                        <h3 class="truncate text-black">Flavour:
                                                            @php
                                                                $flavour = \App\Models\Flavour::find($cart->flavour_id);
                                                            @endphp
                                                            {{$flavour->names}}
                                                        </h3>
                                                        <h3 class=" text-black">Weight:
                                                            {{ $cart->weight }}
                                                            Pound</h3>
                                                    </div>
                                                </div>

                                                <!-- Edit / Delete icons -->
                                                <div class="flex flex-col items-end ml-4 space-y-2">
                                                    <div class="flex items-center gap-2">
                                                        <!-- Edit -->
                                                        <button type="button"
                                                            class="p-1 rounded hover:bg-gray-100 text-gray-600"
                                                            title="Edit" aria-label="Edit item">
                                                            <!-- pencil icon -->
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>

                                                        <!-- Delete -->
                                                        <button type="button"
                                                            class="p-1 rounded hover:bg-gray-100 text-red-600"
                                                            title="Remove" aria-label="Remove item"
                                                            onclick="deleteCart({{ $cart->id }})">
                                                            <!-- trash icon -->
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="text-right">
                                                        <h2 class="text-[var(--primary)] font-semibold text-lg">Rs.
                                                            {{ number_format($cart->amount, 2) }}</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right: quantity controls -->
                                        <div class="flex flex-col items-center gap-2 ml-2">
                                            <div
                                                class="flex items-center border border-gray-200 rounded-md overflow-hidden">
                                                <button type="button"
                                                    class="px-3 py-1 text-xl leading-none focus:outline-none"
                                                    aria-label="Decrease quantity"
                                                    onclick="updateQty({{ $cart->id }}, {{ $cart->qty - 1 }})">−</button>

                                                <input type="number" value="{{ $cart->qty }}" min="1"
                                                    max="10"
                                                    class="w-12 text-center text-sm border-l border-r border-gray-200 focus:outline-none"
                                                    aria-label="Quantity" readonly
                                                    onchange="updateQty({{ $cart->id }}, this.value)" />

                                                <button type="button"
                                                    class="px-3 py-1 text-xl leading-none focus:outline-none"
                                                    aria-label="Increase quantity"
                                                    onclick="updateQty({{ $cart->id }}, {{ $cart->qty + 1 }})">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
                <div class="col-span-4">
                    <div class="sticky top-22 max-w-sm mx-auto bg-white shadow-md rounded-lg p-6">
                        <!-- Title -->
                        <h2 class="text-xl font-bold mb-4">Cart Summary</h2>

                        <!-- Subtotal & Discount -->
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-900">Rs. <span id="totalAmount">0.00</span></span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Discount</span>
                            <span class="font-semibold text-gray-900">Rs. 0</span>
                        </div>
                        <hr class="border-dashed mb-4">

                        <!-- Grand Total -->
                        <div class="flex justify-between mb-4">
                            <span class="font-semibold text-gray-900">Grand Total</span>
                            <span class="font-bold text-gray-900 text-lg" id="grantTotal">Rs. 0</span>
                        </div>

                        <!-- Coupon Code -->
                        <div class="flex mb-2">
                            <input type="text" placeholder="Enter Coupon Code"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <button
                                class="bg-orange-500 text-white px-4 py-2 rounded-r-md font-semibold hover:bg-orange-600">APPLY</button>
                        </div>

                        <!-- Promo Banner -->
                        <div class="bg-red-200 text-red-500 text-sm font-semibold py-2 px-3 rounded-md mb-4">
                            10% Off* on 1st Order, Code: WELCOME
                        </div>

                        <!-- Checkout Button -->
                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-32 py-3 rounded-sm font-medium">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Get all checkboxes
        const checkboxes = document.querySelectorAll('.cart-checkbox');
        const totalAmountEl = document.getElementById('totalAmount');
        const grantTotalEl = document.getElementById('grantTotal');
        const discountInput = document.getElementById('discount'); // optional discount input

        function calculateTotal() {
            let total = 0;

            // Sum checked items
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseFloat(cb.dataset.amount);
                }
            });

            // Format total with commas and 2 decimals
            totalAmountEl.textContent = total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Get discount value (can be percentage or fixed)
            let discount = discountInput ? parseFloat(discountInput.value) || 0 : 0;

            // Example: if discount is percentage
            // let grandTotal = total - (total * discount / 100);

            // Example: if discount is fixed amount
            let grandTotal = total - discount;

            // Format Grand Total
            grantTotalEl.textContent = grandTotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Add change event listener to all checkboxes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', calculateTotal);
        });

        // If you have a discount input, update grand total on change
        if (discountInput) {
            discountInput.addEventListener('input', calculateTotal);
        }

        // Initial calculation
        calculateTotal();

        function updateQty(cartId, qty) {
            if (qty < 1 || qty > 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Quantity',
                    text: 'Quantity must be between 1 and 10.',
                });
                return;
            }
            fetch('/cart/update/' + cartId, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        qty: qty
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: 'Cart quantity updated successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update quantity.',
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the cart.',
                    });
                });
        }

        function deleteCart(cartId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to remove this item from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0c9cd7',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/cart/delete/' + cartId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed',
                                    text: 'Item removed from cart!',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to remove item.',
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while removing the item.',
                            });
                        });
                }
            });
        }

        // function placeOrder(shopId) {
        //     Swal.fire({
        //         title: 'Confirm Order',
        //         text: 'Are you sure you want to place this order?',
        //         icon: 'question',
        //         showCancelButton: true,
        //         confirmButtonColor: '#0c9cd7',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, place order!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             fetch('/order/create/' + shopId, {
        //                     method: 'POST',
        //                     headers: {
        //                         'Content-Type': 'application/json',
        //                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //                     }
        //                 })
        //                 .then(response => response.json())
        //                 .then(data => {
        //                     if (data.success) {
        //                         Swal.fire({
        //                             icon: 'success',
        //                             title: 'Order Placed',
        //                             text: 'Your order has been placed successfully!',
        //                             timer: 1500,
        //                             showConfirmButton: false
        //                         }).then(() => {
        //                             window.location.href = '/order/confirmation/' + data.orderId;
        //                         });
        //                     } else {
        //                         Swal.fire({
        //                             icon: 'error',
        //                             title: 'Error',
        //                             text: 'Failed to place order.',
        //                         });
        //                     }
        //                 })
        //                 .catch(error => {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Error',
        //                         text: 'An error occurred while placing the order.',
        //                     });
        //                 });
        //         }
        //     });
        // }
    </script>
</x-frontend-layout>

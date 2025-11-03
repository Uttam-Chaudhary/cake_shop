<x-frontend-layout title="multiple order" description="this is meta description" keywords="this is meta keywords">
    <form method="POST" action="{{ route('checkout.place') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left: Delivery & Payment Form -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-semibold mb-6 text-gray-900 pb-3 border-b border-gray-200">Delivery
                    Information</h2>
                <input type="hidden" name="total_amount" id="total_input" value="0">
                <!-- Delivery Information -->
                <div class="space-y-5">
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Delivery
                            Address</label>
                        <textarea name="address" id="address" required
                            class="form-input mt-1 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                            rows="3" placeholder="Enter your full delivery address"></textarea>
                        @error('address')
                            <div class="text-red-500 text-sm mt-1">{{ $address }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">Contact
                            Number</label>
                        <input type="text" name="contact" id="contact" required
                            class="form-input mt-1 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                            placeholder="Enter your phone number">
                        @error('contact')
                            <div class="text-red-500 text-sm mt-1">{{ $contact }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="date" class=" text-sm font-medium text-gray-900 ">Select Delivery
                            Date</label>
                        <input type="date" name="date" min="{{ date('Y-m-d') }}" value=" " required
                            class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        @error('date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="pt-6 border-t border-gray-200">
                    <h2 class="text-xl font-semibold mb-6 text-gray-900">Payment Method</h2>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Select your preferred payment
                        method</label>
                    <div class="grid gap-2">
                        <!-- Cash on Delivery -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="cash_on_delivery" class="sr-only peer"
                                checked>
                            <div
                                class="payment-option peer-checked:bg-indigo-50 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 border-2 border-gray-200 rounded-xl p-4 text-center hover:shadow-md transition-all duration-300 bg-white">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                        <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3V0m6 0h4" />
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm text-gray-800">Cash on Delivery</h3>
                                    <p class="text-xs text-gray-500 mt-1">Pay when you receive</p>
                                </div>
                            </div>
                        </label>

                        <!-- QR Payment -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="qr_payment" class="sr-only peer">
                            <div
                                class="payment-option peer-checked:bg-indigo-50 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 border-2 border-gray-200 rounded-xl p-4 text-center hover:shadow-md transition-all duration-300 bg-white">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                        <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.583m-1.5.583a6.01 6.01 0 01-1.5-.583M9.75 9.75c0 .621-.504 1.125-1.125 1.125H5.25M18.75 9.75c0 .621-.504 1.125-1.125 1.125H15m0 0c-.621 0-1.125.504-1.125 1.125v3.75c0 .621.504 1.125 1.125 1.125h3.75c.621 0 1.125-.504 1.125-1.125V12.75c0-.621-.504-1.125-1.125-1.125z" />
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm text-gray-800">QR Payment</h3>
                                    <p class="text-xs text-gray-500 mt-1">Scan & Pay</p>
                                </div>
                            </div>
                        </label>

                        <!-- Pay with Khalti -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="khalti" class="sr-only peer">
                            <div
                                class="payment-option peer-checked:bg-indigo-50 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 border-2 border-gray-200 rounded-xl p-4 text-center hover:shadow-md transition-all duration-300 bg-white">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                        <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5m12 0v2a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm text-gray-800">Pay with Khalti</h3>
                                    <p class="text-xs text-gray-500 mt-1">Digital Wallet</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- QR Payment Details -->
                    <div id="qrReceipt" class="hidden mt-6 space-y-4 p-5 bg-gray-50 rounded-xl border border-gray-200">
                        <h3 class="font-medium text-gray-800">Complete QR Payment</h3>
                        <div class="">
                            <div class="flex justify-center md:justify-start">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg"
                                    alt="QR Payment Code"
                                    class="w-40 h-40 object-contain rounded-lg bg-white p-3 shadow-sm border border-gray-200">
                            </div>
                            <div class="mt-4 md:mt-0 flex-1">
                                <div>
                                    <label for="payment_receipt_image"
                                        class="block text-sm font-medium text-gray-700 mb-1">Upload Receipt</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="file" id="payment_receipt_image" name="payment_receipt_image"
                                            accept="image/*"
                                            class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                    <div>
                                        <label for="transaction_id"
                                            class=" text-sm font-medium text-gray-900 ">Transaction Code <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="transaction_id" id="transaction_id"
                                            value="{{ old('transaction_id') }}"
                                            class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                        @error('transaction_id')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold text-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Place Order & Pay
                </button>

            </div>

            <!-- Right: Order Summary -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200 h-fit sticky top-20">
                <h2 class="text-xl font-semibold mb-6 text-gray-900 pb-3 border-b border-gray-200">Order
                    Summary
                </h2>
                <div class="space-y-6">
                    <div class="max-h-96 overflow-y-auto pr-2">
                        @foreach ($carts->groupBy('product.shop_id') as $shopId => $shopCarts)
                            <h2>{{ $shopCarts->first()->product->shop->name }}</h2>
                            @foreach ($shopCarts as $cart)
                                <div
                                    class="order-item flex justify-between items-start p-4 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="selected_carts[]"
                                                    value="{{ $cart->id }}"
                                                    class="cart-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300"
                                                    data-amount="{{ $cart->amount }}" checked hidden>
                                            </label>
                                        </div>

                                        @if (!empty($cart->product->images))
                                            <img src="{{ asset('storage/' . $cart->product->images[0]) }}"
                                                alt="{{ $cart->product->name }}"
                                                class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0"></div>
                                        @endif

                                        <div>
                                            <h3 class="text-base font-medium text-gray-800">
                                                {{ $cart->product->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">Quantity: {{ $cart->qty }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">Weight: {{ $cart->weight }}
                                                Pound</p>
                                        </div>
                                    </div>

                                    <div class="text-base font-semibold text-gray-800 whitespace-nowrap">
                                        Rs.{{ number_format($cart->amount, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="pt-4 border-t border-gray-200 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal</span>
                            <span id="subtotal" class="text-gray-800 font-medium">Rs. 0.00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Delivery Fee</span>
                            <span class="text-gray-800 font-medium">Rs.100.00</span>
                        </div>
                        <div
                            class="flex justify-between items-center text-lg font-semibold pt-3 border-t border-gray-200">
                            <span class="text-gray-900">Total</span>
                            <span id="total" class="text-indigo-600">Rs. 0.00</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-indigo-600 mt-0.5 mr-2 flex-shrink-0" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-indigo-700">
                            You will receive a confirmation email shortly after placing your order.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrRadio = document.querySelector('input[value="qr_payment"]');
            const qrReceipt = document.getElementById('qrReceipt');
            const fileInput = document.getElementById('payment_receipt_image');
            const transactionCodeInput = document.getElementById('transaction_id');

            function toggleQrReceipt() {
                if (qrRadio.checked) {
                    qrReceipt.classList.remove('hidden');
                    fileInput.setAttribute('required', 'required');
                    transactionCodeInput.setAttribute('required', 'required');

                } else {
                    qrReceipt.classList.add('hidden');
                    fileInput.removeAttribute('required');
                    transactionCodeInput.removeAttribute('required');
                }
            }

            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', toggleQrReceipt);
            });

            toggleQrReceipt(); // Initial check
        });


        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".cart-checkbox");
            const subtotalEl = document.getElementById("subtotal");
            const totalEl = document.getElementById("total");
            const deliveryFee = 100;

            const totalInput = document.getElementById("total_input");

            function updateTotals() {
                let subtotal = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        subtotal += parseFloat(cb.dataset.amount);
                    }
                });

                // If nothing is selected, delivery fee = 0
                const total = subtotal > 0 ? subtotal + deliveryFee : 0;

                subtotalEl.textContent = "Rs." + subtotal.toFixed(2);
                totalEl.textContent = "Rs." + total.toFixed(2);
                totalInput.value = total;
            }

            // ✅ Automatically run on page load
            updateTotals();

            // ✅ Recalculate dynamically if user unchecks or rechecks an item
            checkboxes.forEach(cb => cb.addEventListener("change", updateTotals));
        });
    </script>

</x-frontend-layout>

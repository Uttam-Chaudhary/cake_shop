<x-frontend-layout title="home" description="this is meta description" keywords="this is meta keywords">
    <div class="container py-10">
        <h1 class="text-2xl font-bold text-[var(--primary)] mb-3">My Cart</h1>
        <form id="checkoutForm" action="{{ route('checkout.select') }}" method="POST">
            @csrf
            <div class="grid lg:grid-cols-12 gap-2">
                <div class="col-span-8">
                    <div class="p-3 bg-white border border-gray-200 shadow-sm">
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
                                {{ optional($shopCarts->first()->product->shop)->name ?? 'Shop' }}
                            </h2>
                            @foreach ($shopCarts as $cart)
                                <div class="max-w-4xl mx-auto my-4">
                                    <div class="lg:hidden bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                        <div
                                            class="flex items-center gap-4 ">
                                            <!-- Left: checkbox -->
                                            <div class="flex-shrink-0">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="selected_carts[]"
                                                        value="{{ $cart->id }}"
                                                        class="cart-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300"
                                                        data-amount="{{ $cart->amount }}"
                                                        data-shop="{{ $shopId }}">
                                                </label>
                                            </div>
                                            <!-- Image -->
                                            <div class="flex-shrink-0">
                                                @php
                                                    // safe image access; fallback to placeholder if none
                                                    $img = null;
                                                    if (
                                                        !empty($cart->product) &&
                                                        !empty($cart->product->images) &&
                                                        isset($cart->product->images[0])
                                                    ) {
                                                        $img = $cart->product->images[0];
                                                    }
                                                @endphp
                                                @if ($img)
                                                    <img src="{{ asset(Storage::url($img)) }}"
                                                        alt="{{ $cart->product->name ?? 'product' }}"
                                                        class="w-20 h-20 object-cover rounded-md border" />
                                                @else
                                                    {{-- Replace with your app placeholder path if you have one --}}
                                                    <img src="{{ asset('images/placeholder.png') }}" alt="no-image"
                                                        class="w-20 h-20 object-cover rounded-md border" />
                                                @endif
                                            </div>

                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 leading-tight">
                                                    {{ $cart->product->name ?? 'Product' }}</h3>
                                                <div class="mt-2 text-gray-600 text-sm space-y-0">
                                                    <h3 class="truncate text-black">Flavour:
                                                        @php
                                                            $flavour = \App\Models\Flavour::find($cart->flavour_id);
                                                        @endphp
                                                        {{ $flavour->names ?? '-' }}
                                                    </h3>
                                                    <h3 class="text-black">Weight:
                                                        {{ $cart->weight ?? '-' }}
                                                        Pound</h3>
                                                    <h3 class="truncate text-black">Message:
                                                        {{ $cart->message ?? '-' }}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit / Delete icons -->
                                        <div class="flex flex-col items-end ml-4 space-y-2">
                                            <div class="flex items-center gap-2">
                                                <!-- Edit -->
                                                <button type="button"
                                                    class="p-1 rounded hover:bg-gray-100 text-gray-600" title="Edit"
                                                    aria-label="Edit item" onclick="editCart({{ $cart->id }})">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </button>

                                                <!-- Delete -->
                                                <button type="button"
                                                    class="p-1 rounded hover:bg-gray-100 text-red-600" title="Remove"
                                                    aria-label="Remove item" onclick="deleteCart({{ $cart->id }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <h2 class="text-[var(--primary)] font-semibold text-lg">Rs.
                                                    {{ number_format($cart->amount, 2) }}</h2>
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

                                    <div
                                        class="hidden lg:flex items-center gap-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                        <!-- Left: checkbox -->
                                        <div class="flex-shrink-0">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="selected_carts[]"
                                                    value="{{ $cart->id }}"
                                                    class="cart-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300"
                                                    data-amount="{{ $cart->amount }}" data-shop="{{ $shopId }}">
                                            </label>
                                        </div>

                                        <!-- Image -->
                                        <div class="flex-shrink-0">
                                            @php
                                                // safe image access; fallback to placeholder if none
                                                $img = null;
                                                if (
                                                    !empty($cart->product) &&
                                                    !empty($cart->product->images) &&
                                                    isset($cart->product->images[0])
                                                ) {
                                                    $img = $cart->product->images[0];
                                                }
                                            @endphp

                                            @if ($img)
                                                <img src="{{ asset(Storage::url($img)) }}"
                                                    alt="{{ $cart->product->name ?? 'product' }}"
                                                    class="w-20 h-20 object-cover rounded-md border" />
                                            @else
                                                {{-- Replace with your app placeholder path if you have one --}}
                                                <img src="{{ asset('images/placeholder.png') }}" alt="no-image"
                                                    class="w-20 h-20 object-cover rounded-md border" />
                                            @endif
                                        </div>

                                        <!-- Middle: product info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 leading-tight truncate w-50">
                                                        {{ $cart->product->name ?? 'Product' }}</h3>

                                                    <div class="mt-2 text-gray-600 text-sm space-y-0">
                                                        <h3 class="truncate text-black">Flavour:
                                                            @php
                                                                $flavour = \App\Models\Flavour::find($cart->flavour_id);
                                                            @endphp
                                                            {{ $flavour->names ?? '-' }}
                                                        </h3>
                                                        <h3 class="text-black">Weight:
                                                            {{ $cart->weight ?? '-' }}
                                                            Pound</h3>
                                                        <h3 class="truncate text-black">Message:
                                                            {{ $cart->message ?? '-' }}
                                                        </h3>
                                                    </div>
                                                </div>

                                                <!-- Edit / Delete icons -->
                                                <div class="flex flex-col items-end ml-4 space-y-2">
                                                    <div class="flex items-center gap-2">
                                                        <!-- Edit -->
                                                        <button type="button"
                                                            class="p-1 rounded hover:bg-gray-100 text-gray-600"
                                                            title="Edit" aria-label="Edit item"
                                                            onclick="editCart({{ $cart->id }})">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>

                                                        <!-- Delete -->
                                                        <button type="button"
                                                            class="p-1 rounded hover:bg-gray-100 text-red-600"
                                                            title="Remove" aria-label="Remove item"
                                                            onclick="deleteCart({{ $cart->id }})">
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
                                class="flex-1 lg:px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <button
                                class="  bg-orange-500 text-white px-2 xl:px-4 py-2 rounded-r-md font-semibold hover:bg-orange-600">APPLY</button>
                        </div>

                        <!-- Promo Banner -->
                        <div class="bg-red-200 text-red-500 text-sm font-semibold py-2 px-3 rounded-md mb-4">
                            10% Off* on 1st Order, Code: WELCOME
                        </div>

                        <!-- Checkout Button -->
                        <button type="submit"
                            class=" bg-orange-500 hover:bg-orange-600 text-white px-32 lg:px-24 xl:px-32 py-3 rounded-sm font-medium">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Edit Cart Modal -->
    <div id="editCartModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-xl mx-4">
            <div class="px-6 py-4 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Edit Cart Item</h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-500 hover:text-gray-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <form id="editCartForm" class="px-6 py-4" onsubmit="submitEditForm(event)">
                @csrf
                @method('PATCH')

                <input type="hidden" id="editCartId" name="cart_id" value="">

                <!-- Flavour -->
                <div class="mb-4">
                    <label for="editFlavour" class="block text-sm font-medium text-gray-700">Flavour</label>
                    <select id="editFlavour" name="flavour_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">-- Select flavour --</option>
                        {{-- options populated by JS --}}
                    </select>
                </div>

                <!-- weight -->
                <div class="mb-4">
                    <label for="editWeight" class="block text-sm font-medium text-gray-700">Weight</label>
                    <select id="editWeight" name="weight" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">-- Select Weight --</option>
                        {{-- options populated by JS --}}
                    </select>
                </div>

                <!-- Message -->
                <div class="mb-4">
                    <label for="editMessage" class="block text-sm font-medium text-gray-700">Message on Cake</label>
                    <textarea id="editMessage" name="message" rows="3" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 rounded border hover:bg-gray-50">Cancel</button>

                    <button type="submit" id="editSaveBtn"
                        class="px-4 py-2 rounded bg-orange-500 text-white hover:bg-orange-600">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // show modal
        function showEditModal() {
            const modal = document.getElementById('editCartModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // close modal
        function closeEditModal() {
            const modal = document.getElementById('editCartModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Called by your edit buttons: editCart(cartId)
        async function editCart(cartId) {
            try {
                const res = await fetch(`/cart/${cartId}/edit`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) {
                    throw new Error('Could not fetch cart data');
                }

                const json = await res.json();
                if (!json.success) throw new Error('Failed to fetch cart');

                const cart = json.cart;
                const flavours = json.flavours || [];
                // populate inputs
                document.getElementById('editCartId').value = cart.id;
                document.getElementById('editMessage').value = cart.message ?? '';

                // populate weight select
                const weightSelect = document.getElementById('editWeight');
                weightSelect.innerHTML = '<option value="">-- Select weight --</option>';
                (json.weights || []).forEach(w => {
                    const opt = document.createElement('option');
                    opt.value = w.weight;
                    opt.textContent = w.weight;
                    if (cart.weight && cart.weight === w.weight) opt.selected = true;
                    weightSelect.appendChild(opt);
                });

                // populate flavour select
                const flavourSelect = document.getElementById('editFlavour');
                flavourSelect.innerHTML = '<option value="">-- Select flavour --</option>';
                flavours.forEach(f => {
                    const opt = document.createElement('option');
                    opt.value = f.id;
                    opt.textContent = f.names;
                    if (cart.flavour_id && cart.flavour_id === f.id) opt.selected = true;
                    flavourSelect.appendChild(opt);
                });

                showEditModal();
            } catch (err) {
                console.error(err);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    timer: 3000,
                    text: 'Failed to open edit dialog.',
                });
            }
        }

        // submit the edit form with PATCH to server
        async function submitEditForm(event) {
            event.preventDefault();

            const cartId = document.getElementById('editCartId').value;
            const payload = {
                flavour_id: document.getElementById('editFlavour').value || null,
                weight: document.getElementById('editWeight').value,
                message: document.getElementById('editMessage').value,
            };

            const saveBtn = document.getElementById('editSaveBtn');
            saveBtn.disabled = true;

            try {
                const res = await fetch(`/cart/${cartId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload),
                });

                const json = await res.json();

                if (res.status === 422) {
                    const firstError = json.errors ? Object.values(json.errors)[0][0] : 'Validation error';
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Validation',
                        timer: 2000,
                        text: firstError,
                        showConfirmButton: false
                    });
                    saveBtn.disabled = false;
                    return;
                }

                if (!json.success) {
                    throw new Error(json.message || 'Update failed');
                }

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Updated',
                    text: json.message || 'Cart item updated',
                    timer: 1400,
                    showConfirmButton: false
                }).then(() => {
                    closeEditModal();
                    location.reload();
                });

            } catch (err) {
                console.error(err);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating cart.',
                });
                saveBtn.disabled = false;
            }
        }

        // optional: close modal when clicking outside the panel
        document.getElementById('editCartModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        function updateQty(cartId, qty) {
            if (qty < 1 || qty > 10) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    icon: 'warning',
                    title: 'Invalid Quantity',
                    text: 'Quantity must be between 1 and 10.',
                    showConfirmButton: false
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
                            toast: true,
                            position: 'top-end',
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
                                    toast: true,
                                    position: 'top-end',
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
                                    toast: true,
                                    position: 'top-end',
                                    timer: 1500,
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to remove item.',
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                timer: 1500,
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while removing the item.',
                            });
                        });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = Array.from(document.querySelectorAll('.cart-checkbox'));
            const totalAmountEl = document.getElementById('totalAmount');
            const grantTotalEl = document.getElementById('grantTotal');
            const discountInput = document.getElementById('discount'); // optional, may be null

            function formatCurrency(num) {
                return Number(num).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            if (!totalAmountEl || !grantTotalEl) {
                // nothing to do if totals UI missing
                return;
            }

            function calculateTotal() {
                let total = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        const amt = parseFloat(cb.dataset.amount || 0);
                        total += isNaN(amt) ? 0 : amt;
                    }
                });

                totalAmountEl.textContent = formatCurrency(total);

                let discount = 0;
                if (discountInput) {
                    discount = parseFloat(discountInput.value) || 0;
                }

                const grandTotal = Math.max(0, total - discount);
                grantTotalEl.textContent = formatCurrency(grandTotal);

                // enable/disable checkout button if needed
                const checkoutBtn = document.querySelector('#checkoutForm button[type="submit"]');
                if (checkoutBtn) checkoutBtn.disabled = (total === 0);
            }

            function onCheckboxChange(e) {
                const cb = e.target;
                if (!cb || !cb.dataset.shop) {
                    calculateTotal();
                    return;
                }

                if (cb.checked) {
                    const selectedShop = cb.dataset.shop;
                    let otherUnChecked = false;
                    checkboxes.forEach(other => {
                        if (other === cb) return;
                        if (other.dataset.shop !== selectedShop && other.checked) {
                            other.checked = false;
                            otherUnChecked = true;
                        }
                    });

                    if (otherUnChecked && typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Only items from one shop can be checked. Items from other shops were unchecked.',
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }
                }

                calculateTotal();
            }

            if (checkboxes.length > 0) {
                checkboxes.forEach(cb => cb.addEventListener('change', onCheckboxChange));
            }

            if (discountInput) {
                discountInput.addEventListener('input', calculateTotal);
            }

            const checkoutForm = document.getElementById('checkoutForm');
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', (ev) => {
                    const checked = Array.from(document.querySelectorAll('.cart-checkbox')).filter(cb => cb
                        .checked);
                    const shops = new Set(checked.map(cb => cb.dataset.shop));
                    if (shops.size > 1) {
                        ev.preventDefault();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                icon: 'warning',
                                title: 'Only one shop allowed',
                                text: 'Please select items from only one shop before checkout.'
                            });
                        } else {
                            alert('Please select items from only one shop.');
                        }
                    }
                    if (checked.length === 0) {
                        ev.preventDefault();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                timer: 2000,
                                icon: 'warning',
                                title: 'No Items Selected',
                                text: 'Please select at least one item to checkout.'
                            });
                        } else {
                            alert('Please select at least one item to checkout.');
                        }
                    }
                });
            }

            calculateTotal();
        });
    </script>
</x-frontend-layout>

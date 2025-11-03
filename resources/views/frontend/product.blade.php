<x-frontend-layout :title="$product->name" description="this is meta description" keywords="this is meta keywords">
    <section class="mt-8">
        <div class="container mx-auto">
            <!-- Breadcrumbs -->
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="flex gap-2 items-center">
                    <li><a href="{{ route('home') }}" class="hover:underline text-black">Home</a></li>
                    <li>/</li>
                    <li class="text-gray-700">{{ $product->name }}</li>
                </ol>
            </nav>
            <div class="grid grid-cols-2 gap-10">
                <div class=" grid grid-cols-12 gap-5 sticky top-1 self-start h-fit">
                    <div class=" col-span-3">
                        @foreach ($product->images as $img)
                            <div
                                class="cursor-pointer border-2 border-transparent hover:border-blue-500 rounded-lg overflow-hidden transition-all">
                                <img src="{{ asset(Storage::url($img)) }}" alt=""
                                    class="w-full h-24 object-cover" onclick="changeImage(this.src)">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-span-9">
                        <div class="rounded-lg overflow-hidden shadow-lg mb-4">
                            <img id="mainImage" src="{{ asset(Storage::url($product->images[0])) }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div>
                    <form action="{{ route('cart.store', $product->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="weight" id="selected-weight"
                            value="{{ $product->weights[0]['weight'] ?? '' }}">
                        <input type="hidden" name="flavour_id" id="selected-flavour" value="">

                        <h1 class="text-xl font-semibold">{{ $product->name }}</h1>
                        <h2 id="product-price" class="text-xl mt-3 font-semibold">
                            Rs.{{ number_format($product->price - ($product->price * $product->discount_percentage) / 100, 2) }}
                        </h2>
                        @if ($product->discount_percentage > 0)
                        <span class="text-red-500">({{ $product->discount_percentage }}% off)</span>
                        @endif
                        <h3 class="mt-3 text-black">Choose Weight (in pound)</h3>
                        <div id="weight-buttons" class="flex flex-wrap gap-2 mt-2">
                            @foreach ($product->weights as $w)
                                <button type="button"
                                    class="px-3 py-1.5 rounded border border-gray-300 hover:border-orange-500
                {{ $loop->first ? 'bg-red-500 text-white border-red-500' : '' }}"
                                    data-weight="{{ $w['weight'] }}">
                                    {{ $w['weight'] }}
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-3 rounded">
                            <label for="message" class="block text-md font-medium text-gray-900 mb-1">Message on
                                Cake</label>
                            <input id="message" type="text" name="message" placeholder="Enter message on cake"
                                value="{{ old('message') }}"
                                class="block h-12 w-full bg-white py-1.5 px-3 text-base text-gray-900 placeholder:text-gray-400
            focus:outline-none focus:ring-2 rounded"
                                style="--tw-ring-color: var(--secondary);" />
                            @error('message')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <label for="flavour" class="block text-md font-medium mt-3">Choose flavour</label>
                            <select id="flavour" name="flavour_id"
                                class="mt-1 block w-full rounded-md border-gray-300">
                                <option value=" {{ old('flavour_id') }}">Select a flavour</option>
                                @foreach ($product->flavours as $flavour)
                                    <option value="{{ $flavour->id }}"
                                        {{ old('flavour_id') == $flavour->id ? 'selected' : '' }}>
                                        {{ $flavour->names }}
                                    </option>
                                @endforeach
                            </select>
                            @error('flavour_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class=" mt-3 bg-yellow-100 border-2 border-red-300 rounded-sm p-3 gap-3"> <label
                                for="date" class=" text-sm font-medium text-gray-900 ">Select Delivery Date</label>
                            <input type="date" name="date" min="{{ date('Y-m-d') }}" value=" "
                                class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('date')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (!empty($product->note))
                            <div
                                class=" border-l-4 border-red-500 bg-red-100 mt-3 p-3 text-red-500 text-md font-semibold">
                                <h2> Note: {{ $product->note }}</h2>
                            </div>
                        @endif
                        <div class=" mt-3 bg-white border-white">
                            <a class=" text-sm" href="tel:+977 {{ $product->shop->phone }}"> You can place last-minute
                                order by calling
                                us at <span class=" text-orange-500"> {{ $product->shop->phone }}</span></a>
                        </div>
                        <div class="mt-3 flex space-x-12">
                            <button type="submit"
                                class=" hover:bg-[var(--secondary)] text-[var(--primary)] hover:text-white border border-[var(--primary)] py-3 px-6 rounded-lg flex items-center transition-colors">
                                <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                            </button>

                            <button type="submit" formaction="{{ route('checkout.buyNow', $product->id) }}"
                                class="bg-[var(--primary)] hover:bg-[var(--secondary)] text-white py-3 px-6 rounded-lg flex items-center transition-colors">
                                <i class="fa-solid fa-bag-shopping mr-2"></i> Buy Now
                            </button>
                        </div>
                    </form>
                    <div class=" mt-3">
                        <h2 class="text-lg font-semibold">Description</h2>
                        <h3>{!! $product->description !!}</h3>
                    </div>

                </div>


            </div>
        </div>
    </section>

    <script>
        // Function to change the main image when clicking on thumbnails
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }
        document.addEventListener("DOMContentLoaded", function() {
            const basePrice = {{ ($product->price - ($product->price * $product->discount_percentage) / 100 )/ $product->weights[0]['weight'] }};
            const priceElement = document.getElementById("product-price");
            const weightButtons = document.querySelectorAll("#weight-buttons button");

            weightButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Remove active (red) style from all buttons
                    weightButtons.forEach(btn => {
                        btn.classList.remove("bg-red-500", "text-white", "border-red-500");
                        btn.classList.add("border-gray-300");
                    });

                    // Add active style to the clicked one
                    this.classList.add("bg-red-500", "text-white", "border-red-500");
                    this.classList.remove("border-gray-300");

                    // Get selected weight
                    const selectedWeight = parseFloat(this.dataset.weight);
                    document.getElementById("selected-weight").value = selectedWeight;


                    // Calculate total price
                    const totalPrice = basePrice * selectedWeight;

                    // Update price text
                    priceElement.textContent = "Rs. " + totalPrice.toLocaleString("en-IN", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                });
            });
        });
    </script>
</x-frontend-layout>

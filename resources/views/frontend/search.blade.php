<x-frontend-layout title="home" description="this is meta description" keywords="this is meta keywords">
    <section>
        <div class="container py-10">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    Search Result for "{{ $q }}"
                </h2>
            </div>

            @if (count($products) > 0)
                <div class="grid grid-cols-4 gap-5">
                    @foreach ($products as $product)
                        <a href="{{ route('product', $product->id) }}">
                            <div
                                class="mt-5 max-w-xs bg-white border border-gray-200 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800 dark:border-gray-700">
                                <div class="relative rounded-t-2xl overflow-hidden h-56 group">
                                    <img class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110 group-hover:shadow-2xl"
                                        src="{{ asset(Storage::url($product->images[0])) }}" alt="Cake" />
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent rounded-t-2xl">
                                    </div>
                                </div>
                                <div class="p-6 mb-3">
                                    <h3 class="mb-2 text-md font-medium text-black truncate w-50">
                                        {{ $product->name }}
                                    </h3>
                                    <h5 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white">
                                        Rs. {{ number_format($product->price, 2) }}
                                    </h5>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <h3>
                    No products found
                </h3>
            @endif
        </div>
    </section>
</x-frontend-layout>

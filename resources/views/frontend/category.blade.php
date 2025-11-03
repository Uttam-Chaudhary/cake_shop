<x-frontend-layout :title="$category->title" description="this is meta description" keywords="this is meta keywords">
    <section class=" mt-10">
        <div class="container mx-auto bg-gray-100 rounded-lg overflow-hidden">
            <img class=" object-cover" src="{{ asset(Storage::url($category->banner)) }}" alt="{{ $category->title }}">
        </div>
    </section>
    <section class=" mt-5">
        <div class=" container mx-auto flex items-center gap-1  text-2xl font-semibold ">
            <h3 class="text-[var(--secondary)]">{{ $category->title }} </h3> : <span
                class=" text-[var(--text-black)]">{{ $category->heading }}</span>
        </div>
        <div class="container pt-5 mx-auto text-[var(--text-black)] text-xl">
            <p>{!! $category->description !!}</p>
        </div>
    </section>

    <section class="container mx-auto ">
        <div class="grid grid-cols-4 gap-5 mt-8">
            @foreach ($products as $product)
                <a href="{{ route('product', $product->id) }}">
                    <div
                        class="mt-5 max-w-xs bg-white border border-gray-200 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800 dark:border-gray-700">
                        <div class="relative rounded-t-2xl overflow-hidden h-56 group">
                            <img class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110 group-hover:shadow-2xl"
                                src="{{ asset(Storage::url($product->images[0])) }}" alt="Cake" />
                            @if ($product->discount_percentage > 0)
                                <span class="absolute top-0 right-0 bg-[red] text-white px-4 py-1">
                                    {{ $product->discount_percentage }}% off
                                </span>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent rounded-t-2xl">
                            </div>
                        </div>
                        <div class="p-6 mb-3">
                            <h3 class="mb-2 text-md font-medium text-black truncate w-50">{{ $product->name }}
                            </h3>
                            <h5 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white">
                                Rs.{{ number_format($product->price - ($product->price * $product->discount_percentage) / 100, 2) }}
                                @if ($product->discount_percentage > 0)
                                    <span class=" ml-5 text-[red] line-through">
                                        Rs.{{ number_format($product->price, 2) }}
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</x-frontend-layout>

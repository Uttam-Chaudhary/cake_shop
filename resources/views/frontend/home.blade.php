<x-frontend-layout title="home" description="this is meta description" keywords="this is meta keywords">
    <style>
        /* Custom CSS to hide the scrollbar for a cleaner look */
        .slider-container {
            /* Firefox */
            scrollbar-width: none;
            /* IE and Edge */
            -ms-overflow-style: none;
            /* Allow smooth scrolling behavior in case the JS scrollBy is not used */
            scroll-behavior: smooth;
        }

        /* Chrome, Safari, Opera */
        .slider-container::-webkit-scrollbar {
            display: none;
        }
    </style>
    <section class="mt-10">
        <div class="container m-auto">
            <div id="default-carousel" class="relative w-full" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://img.lazcdn.com/us/domino/50afba00-d645-4b29-b953-c853e600dec0_NP-1976-688.png_2200x2200q80.png_.avif"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="...">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://img.lazcdn.com/us/domino/0046f7cc-c51f-4676-9add-bb3697b755bf_NP-1976-688.jpg_2200x2200q80.jpg_.avif"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="...">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://img.lazcdn.com/us/domino/9086a7a8-ef00-45f7-83f1-da1bfd5e6c6b_NP-1976-688.jpg_2200x2200q80.jpg_.avif"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="...">
                    </div>
                    <!-- Item 4 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://img.lazcdn.com/us/domino/b090f9a9-3148-4a9f-b446-ef8f954d9fe9_NP-1976-688.jpg_2200x2200q80.jpg_.avif"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="...">
                    </div>
                    <!-- Item 5 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://img.lazcdn.com/us/domino/b29ae191-0179-4597-b7a7-bc104a22f9db_NP-1976-688.jpg_2200x2200q80.jpg_.avif"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="...">
                    </div>
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                        data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                        data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                        data-carousel-slide-to="2"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                        data-carousel-slide-to="3"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                        data-carousel-slide-to="4"></button>
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
    </section>

    <section>
        <div class=" container m-auto">
            <div class="flex items-center justify-center mt-5">
                <div class="w-full max-w-8xl ">
                    <!-- Category Slider Wrapper -->
                    <div class="relative flex items-center group">
                        <!-- Left Arrow Button -->
                        <button id="scrollLeftBtn"
                            class="absolute left-0 z-10 p-2 bg-white rounded-full shadow-lg ring-1 ring-gray-200 opacity-80 transition-opacity duration-300 hover:opacity-100 disabled:opacity-30 disabled:cursor-not-allowed -ml-4 lg:-ml-6"
                            aria-label="Scroll Categories Left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Slider Content (The visible window) -->
                        <!-- We use overflow-x-scroll combined with overflow-x-hidden on the outer container for scroll effects -->
                        <div id="sliderContainer" class="slider-container flex-grow overflow-x-scroll">
                            <!-- Inner Slider (Contains all items, use flex-nowrap to keep them in one row) -->
                            <div id="categorySlider" class="space-x-8 flex flex-nowrap">
                                <!-- Item 1 -->
                                @foreach ($categorys as $category)
                                    <a href="{{ route('category', $category->slug) }}"
                                        class="category-item flex-shrink-0 w-1/10 p-2 flex flex-col items-center cursor-pointer hover:bg-gray-100 rounded-xl transition duration-200">
                                        <div
                                            class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-white shadow-md overflow-hidden bg-pink-100 flex items-center justify-center">
                                            <img src="{{ asset(Storage::url($category->logo)) }}" alt=""
                                                class="w-full h-full object-cover">
                                        </div>
                                        <span
                                            class="mt-2 text-sm font-medium text-gray-700 text-center">{{ $category->title }}</span>
                                    </a>
                                @endforeach

                            </div>
                        </div>

                        <!-- Right Arrow Button -->
                        <button id="scrollRightBtn"
                            class="absolute right-0 z-10 p-2 bg-white rounded-full shadow-lg ring-1 ring-gray-200 opacity-80 transition-opacity duration-300 hover:opacity-100 disabled:opacity-30 disabled:cursor-not-allowed -mr-4 lg:-mr-6"
                            aria-label="Scroll Categories Right">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sliderContainer = document.getElementById('sliderContainer');
                const scrollLeftBtn = document.getElementById('scrollLeftBtn');
                const scrollRightBtn = document.getElementById('scrollRightBtn');

                // Function to calculate the scrolling distance. It scrolls approximately 80% of the visible container width.
                function getScrollDistance() {
                    // Scroll a large percentage of the visible area for a good "next page" effect
                    return sliderContainer.clientWidth * 0.8;
                }

                // Function to update the disabled state of the arrow buttons based on scroll position
                function updateScrollButtons() {
                    const maxScrollLeft = sliderContainer.scrollWidth - sliderContainer.clientWidth;

                    // Check if scroll is near the beginning (within 5 pixels tolerance)
                    scrollLeftBtn.disabled = sliderContainer.scrollLeft <= 5;

                    // Check if scroll is near the end (within 5 pixels tolerance)
                    scrollRightBtn.disabled = sliderContainer.scrollLeft >= maxScrollLeft - 5;
                }

                // Scrolls the container to the right
                scrollRightBtn.addEventListener('click', () => {
                    const distance = getScrollDistance();
                    sliderContainer.scrollBy({
                        left: distance,
                        behavior: 'smooth' // This provides the smooth sliding effect
                    });
                    // Update buttons immediately for responsiveness, though the 'scroll' event will handle the final state
                    setTimeout(updateScrollButtons, 500);
                });

                // Scrolls the container to the left
                scrollLeftBtn.addEventListener('click', () => {
                    const distance = getScrollDistance();
                    sliderContainer.scrollBy({
                        left: -distance,
                        behavior: 'smooth'
                    });
                    // Update buttons immediately
                    setTimeout(updateScrollButtons, 500);
                });

                // Update buttons whenever the user manually scrolls or the page resizes
                sliderContainer.addEventListener('scroll', updateScrollButtons);
                window.addEventListener('resize', updateScrollButtons);

                // Initial check to set the correct state for the left arrow (it should be disabled initially)
                setTimeout(() => {
                    updateScrollButtons();
                }, 100);
            });
        </script>
    </section>

    <section class=" bg-gray-100 mt-10">
        @foreach ($categories as $category)
            @if (count($category->products) > 0)
                <div class=" container m-auto">
                    <div class=" flex items-center justify-between">
                        <div class=" mt-10">
                            <h1 class=" text-2xl font-semibold">{{ $category->title }}</h1>
                            <h3 class="py-1 text-black">{{ $category->heading }}</h3>
                        </div>
                        <div
                            class="bg-[var(--primary)] rounded-3xl hover:bg-[var(--secondary)] transition duration-300">
                            <div class="py-2 px-4 text-white font-medium">
                                <a href="{{ route('category', $category->slug) }}">View All</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="grid grid-cols-4 gap-5">
                            @foreach ($category->products->where('status', 1) as $product)
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
                                        </div>
                                        <div class="p-6 mb-3">
                                            <h3 class="mb-2 text-md font-medium text-black truncate w-50">
                                                {{ $product->name }}
                                            </h3>
                                            <h5
                                                class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white">
                                                 Rs.{{ number_format($product->price - ($product->price * $product->discount_percentage) / 100 , 2)}}
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
                    </div>
                    <div class="mt-10 h-[1px] bg-gray-300"> </div>
                </div>
            @endif
        @endforeach
    </section>

    <section>
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8 mt-10">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">
                <i class="fas fa-store text-[var(--primary)]"></i> Request to Open Shop
            </h2>

            <form action="{{ route('shop.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                <!-- Shop Name -->
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">
                        <i class="fas fa-tag mr-2 text-[var(--primary)]"></i> Shop Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:outline-none"
                        placeholder="Enter your shop name" required />
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">
                        <i class="fas fa-envelope mr-2 text-[var(--primary)]"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:outline-none"
                        placeholder="Enter your email" required />
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">
                        <i class="fas fa-phone mr-2 text-[var(--primary)]"></i> Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:outline-none"
                        placeholder="Enter your phone number" required />
                    @error('phone')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Shop Photo -->
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">
                        <i class="fas fa-image mr-2 text-[var(--primary)]"></i> Shop Photo
                    </label>
                    <input type="file" name="photo"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-white file:bg-[var(--primary)] hover:file:bg-[var(--secondary  )]" />
                    @error('photo')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit"
                        class="bg-[var(--primary)] text-white px-6 py-2 rounded-lg hover:bg-[var(--secondary    )] transition">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Request
                    </button>
                </div>
            </form>
        </div>
    </section>


</x-frontend-layout>

<x-app-layout>

    @push('css')
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />

        <style>
            .swiper-pagination-bullet {
                background-color: #FEC51C;
                width: 12px;
                height: 12px;
            };

        </style>
    @endpush

    <!-- Slider main container -->
    <div class="swiper mb-10">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($covers as $cover)
                <div class="swiper-slide">
                    <img src="{{ Storage::url($cover->images->first()->path) }}" class="w-full aspect-[3/1] object-cover object-center" alt="">
                </div>
            @endforeach
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev text-[#FEC51C] font-semibold"></div>
        <div class="swiper-button-next text-[#FEC51C] font-semibold"></div>
    </div>

    <x-container>
        <h1 class="text-2xl font-bold text-gray-700 dark:text-white mb-4 mx-6 sm:mx-0 md:mx-0 lg:mx-0">
            Ultimos productos
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mx-6 sm:mx-0 md:mx-0 lg:mx-0">
            @foreach ($lastProducts as $product)
                @if (count($product->variants))
                    <article class="bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow rounded overflow-hidden relative group">
                        <a href="{{ route('products.show', $product) }}">
                            <img src="{{ Storage::url($product->variants->first()->images->first()->path) }}" alt="img-product-{{$product->name}}"
                                class="w-full h-48 object-cover object-center">
        
                            <div class="p-4">
                                <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-1 line-clamp-2 min-h-[56px]">
                                    {{ $product->name }}
                                </h1>
                                <p class="text-gray-900 dark:text-gray-200 mb-4">
                                    S/. {{ $product->variants->first()->price }}
                                </p>
        
                                <span class="btn btn-blue block w-full text-center opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300">
                                    Ver producto
                                </span>
                            </div>
                        </a>
                    </article>  
                @endif
            @endforeach
        </div>
    </x-container>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            const swiper = new Swiper('.swiper', {
                // Optional parameters
                loop: true,

                autoplay: {
                    delay: 6000,
                },

                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        </script>
    @endpush

</x-app-layout>
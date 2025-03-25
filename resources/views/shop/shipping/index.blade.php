<x-app-layout>
    <x-container class="mt-7">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <div class="col-span-2">
                @livewire('shop.shipping-addresses')
            </div>
            
            <div class="col-span-2 md:col-span-1 mx-3 md:mx-0">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border-gray-200 dark:border-gray-700 mb-4">
                    <div class="bg-gray-900 dark:bg-gray-200 text-white dark:text-black p-3 flex justify-between items-center font-medium text-lg">
                        <p class="font-semibold">
                            Resumen de compra ({{ Cart::instance('shopping')->count() }})
                        </p>
                        <a href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>

                    <div class="p-4 text-gray-600 dark:text-gray-200">
                        <ul>
                            @foreach (Cart::content() as $item)
                                <li class="flex items-center space-x-4">
                                    <figure class="shrink-0">
                                        <img class="h-14 aspect-square" src="{{ Storage::url($item->options->image) }}" alt="">
                                    </figure>
                                    <div class="flex-1">
                                        <p class="text-sm">
                                            {{ $item->name }}
                                        </p>
                                        <p class="font-semibold">
                                            S/. {{ $item->price }}
                                        </p>
                                    </div>
                                    <div class="shrink-0">
                                        <p class="font-semibold">
                                            {{ $item->qty }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <hr class="my-4">

                        <div class="flex justify-between">
                            <p class="text-lg">
                                Total
                            </p>

                            <p class="font-semibold">
                                S/. {{Cart::subtotal()}}
                            </p>
                        </div>
                    </div>
                </div>

                <a href="" class="btn btn-blue w-full block text-center">
                    Siguiente
                </a>
            </div>
        </div>
    </x-container>
</x-app-layout>
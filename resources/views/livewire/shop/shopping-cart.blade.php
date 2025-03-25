<div>
    @if (Cart::count())
        <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">
            <div class="lg:col-span-5">
                <div class="flex justify-between items-center mb-3">
                    <h1 class="text-xl text-black dark:text-white font-medium">
                        Carrito ({{ Cart::count() }} productos)
                    </h1>

                    <button class="font-semibold text-gray-700 dark:text-gray-300 hover:text-red-500 underline hover:no-underline"
                        wire:click="destroy()" wire:key="remove-cart">
                        Limpiar carrito
                    </button>
                </div>

                <div class="card card-color">
                    <ul class="space-y-4">
                        @foreach (Cart::content() as $item)
                            <li class="lg:flex lg:items-center">
                                <a href="{{ route('products.show', $item->id) }}">
                                    <img class="w-full lg:w-28 aspect-square object-cover object-center mr-6" src="{{Storage::url($item->options['image'])}}" alt="">
                                </a>
                                <div class="w-80">
                                    <p class="text-lg dark:text-gray-100 text-gray-900">
                                        <a href="{{ route('products.show', $item->id) }}">
                                            {{ $item->name }}
                                        </a>
                                    </p>
                                </div>

                                <p class="dark:text-gray-100 text-gray-900">
                                    S/. {{ $item->price }}
                                </p>

                                <div class="ml-auto">
                                    <button class="btn3 btn-light disabled:cursor-not-allowed" wire:click="decrease('{{ $item->rowId }}')"
                                        wire:key="decrement-{{ $item->rowId }}">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <span class="text-gray-700 dark:text-gray-300 inline-block w-8 text-center">
                                        {{ $item->qty }}
                                    </span>
                                    <button class="btn3 btn-light" wire:click="increase('{{ $item->rowId }}')"
                                        wire:key="incremet-{{ $item->rowId }}">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>

                                <button class="text-red-400 hover:text-red-600 ml-8"
                                    wire:click="removeProductCart('{{ $item->rowId }}')" wire:key="remove-product-cart-{{ $item->rowId }}">
                                    <i class="fa-solid fa-trash fa-xl"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="lg:col-span-2">
                <div class="card card-color">
                    <div class="flex justify-between font-semibold mb-4">
                        <p class="dark:text-gray-100 text-gray-900">
                            Total:
                        </p>

                        <p class="dark:text-gray-200 text-gray-800">
                            S/. {{ Cart::subtotal() }}
                        </p>
                    </div>

                    <a href="{{ route('shipping.index') }}" class="btn btn-blue block w-full text-center">
                        Continuar compra
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="card card-color">
            <div class="flex items-center justify-center">
                <img src="{{ asset('assets/img/carro-vacio.png') }}" alt="carro vacio" class="w-28">
                <p class="text-black dark:text-white ml-8 text-xl font-medium">El carrito se encuentra vacío</p>
            </div>
        </div>
    @endif
</div>

<x-container>
    <div class="card card-color">
        <div class="grid md:grid-cols-2 gap-6 items-center">
            <div class="col-span-1">
                <figure>
                    <img src="{{ Storage::url($this->variantImg->images->first()->path) }}"
                        class="w-full object-contain object-center" alt="product-{{ $product->name }}">
                </figure>
            </div>
            <div class="col-span-1">
                <h1 class="text-xl text-gray-900 dark:text-white font-semibold mb-2">
                    {{ $product->name }} {{ $product->model }}
                </h1>

                <div class="flex space-x-2 items-center mb-4">
                    <ul class="flex space-x-2">
                        <li>
                            <i class="fa-solid fa-star text-yellow-400 fa-sm"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400 fa-sm"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400 fa-sm"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400 fa-sm"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400 fa-sm"></i>
                        </li>
                    </ul>
                    <p class="text-sm text-gray-700 dark:text-gray-300">4.7 (55)</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">SKU: {{$this->variantImg->sku}}</p>
                </div>

                <div class="flex justify-between items-center">
                    <p class="font-semibold text-2xl mb-4 text-gray-600 dark:text-gray-200">
                        S/. {{ $this->variantImg->price }}
                    </p>

                    <p class="text-xl mb-4 text-gray-600 dark:text-gray-200">
                        Stock: {{ $stock }}
                    </p>
                </div>

                <div class="flex space-x-6 items-center mb-4"
                    x-data="{
                        qty: @entangle('qty'),
                        stock: @entangle('stock')
                    }">
                    <button class="btn3 btn-light disabled:cursor-not-allowed"
                        x-on:click="qty -= 1"
                        x-bind:disabled="qty == 1">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span class="text-gray-700 dark:text-gray-300 inline-block w-8 text-center"
                        x-text="qty">
                    </span>
                    <button class="btn3 btn-light disabled:cursor-not-allowed"
                        x-on:click="qty += 1"
                        x-bind:disabled="qty >= stock">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>

                <div class="flex flex-wrap">
                    @foreach ($this->availableOptions as $optionId => $features)
                        <div class="mr-4 mb-6">
                            <p class="text-gray-800 dark:text-gray-300 font-semibold text-lg mb-2">
                                {{ $features->first()['option']['name'] }}
                            </p>

                            <ul class="flex items-center space-x-4">
                                @foreach ($features as $feature)
                                    <li>
                                        @switch($feature->option->type)
                                            @case(1)
                                                <button class="w-20 h-8 font-semibold uppercase text-sm rounded-lg {{ $selectedFeatures[$feature['option_id']] ==  $feature['id'] ? 'bg-[#9941B8] text-black' : 'border border-gray-200 text-gray-700 dark:text-gray-200 dark:border-gray-500'}}"
                                                    wire:click="$set('selectedFeatures.{{ $feature['option_id'] }}', {{ $feature['id'] }})" wire:key="option-{{ $feature['option_id'] }}-feature-{{ $feature['id'] }}">
                                                    {{ $feature['value'] }}
                                                </button>
                                                @break
                                            @case(2)
                                                <div class="p-0.5 border-2 rounded-lg flex items-center -mt-1.5 {{ $selectedFeatures[$feature['option_id']] ==  $feature['id'] ? 'border-[#9941B8]' : 'border-transparent' }}">
                                                    <button class="w-20 h-8 rounded-lg"
                                                        wire:click="$set('selectedFeatures.{{ $feature['option_id'] }}', {{ $feature['id'] }} )"
                                                        style="background-color: {{$feature['value']}}"
                                                        wire:key="option-{{ $feature['option_id'] }}-feature-{{ $feature['id'] }}">
                                                    </button>
                                                </div>
                                                @break
                                            @default

                                        @endswitch
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endforeach
                </div>

                <button class="btn btn-blue w-full mb-7 {{ $this->variantImg->stock == 0  ? 'disabled:cursor-not-allowed opacity-50' : '' }}"
                    wire:click="addToCart" wire:loading.attr="disabled" @disabled($this->variantImg->stock == 0)>
                    Agregar al carrito
                </button>

                <div class="mb-4">
                    <p class="font-medium text-gray-900 dark:text-white">Marca:</p>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $product->brand->name }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="font-medium text-gray-900 dark:text-white">Modelo:</p>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $product->model }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="font-medium text-gray-900 dark:text-white">Descripción:</p>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $product->description }}
                    </p>
                </div>

                <div class="flex items-center space-x-4 text-gray-800 dark:text-gray-200">
                    <i class="fa-solid fa-truck-fast fa-xl"></i>
                    <p>Despacho a domicilio</p>
                </div>
            </div>
        </div>
    </div>
</x-container>

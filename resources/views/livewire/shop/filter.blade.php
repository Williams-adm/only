<div class="bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 py-10">
    <x-container class="md:flex px-4">
        @if (count($options))
            <aside class="md:w-52 md:flex-shrink-0 md:mr-8 mb-4 md:mb-0">
                <ul class="space-y-4">
                    @foreach ($options as $option)
                        <li x-data="{
                            open: true    
                        }">
                            <button class="px-4 py-2 w-full text-left flex justify-between items-center bg-gray-100 text-black dark:bg-gray-700 dark:text-white font-medium"
                                x-on:click="open = !open">
                                {{ $option['name'] }}
                                <i class="fa-solid fa-angle-down" 
                                    x-bind:class="{
                                        'fa-angle-down' : open,
                                        'fa-angle-up' : !open,
                                    }">
                                </i>
                            </button>

                            <ul class="mt-3 space-y-1" x-show="open">
                                @foreach ($option['features'] as $feature)
                                <li>
                                    <label class="inline-flex items-center text-gray-800 dark:text-gray-200">
                                        <x-checkbox class="mr-2" value="{{ $feature['id'] }}"
                                            wire:model.live="select_features" wire:key="feature-{{ $feature['id'] }}">
                                        </x-checkbox>
                                        {{ $feature['description'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </aside>
        @endif

        <div class="md:flex-1">
            <div class="flex items-center">
                <span class="mr-2 text-gray-900 dark:text-white font-semibold">
                    Ordenar por:
                </span>

                <x-select wire:model.live="orderBy"> 
                    <option value="1" wire:key="rel">Relevancia</option>
                    <option value="2" wire:key="mayor">Precio de mayor a menor</option>
                    <option value="3" wire:key="menor">Precio de menor a mayor</option>
                </x-select>
            </div>

            <hr class="my-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mx-6 sm:mx-0 md:mx-0 lg:mx-0">
                @foreach ($products as $product)
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

            @if ($products->lastPage() > 1)
                <div class="mt-8">
                    {{$products->links()}}
                </div>
            @endif
        </div>
    </x-container>
</div>

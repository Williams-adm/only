<div>
    <section class="block border rounded-lg shadow-sm bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <header class="border-b px-6 py-2 border-gray-300 dark:border-gray-500">
            <div class="flex justify-between">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Opciones
                </h1>

                <x-button wire:click="$set('openModal', true)">
                    Crear
                </x-button>
            </div>
        </header>

        <div class="p-6">
            @if ($product->options->count())
                <div class="space-y-6">
                    @foreach ($product->options as $option)
                        <div wire:key="product-option-{{ $option->id }}"
                            class="p-6 rounded-lg border border-gray-300 dark:border-gray-500 relative">

                            <div class="absolute -top-3 bg-white dark:bg-gray-800">
                                <span class="text-gray-500 dark:text-gray-400 px-3">
                                    {{ $option->name }}
                                </span>
                                <button class="mr-3" onclick="confirmDelete({{$option->id}}, 'deleteOption')">
                                    <li class="fa-solid fa-trash-can hover:text-red-500 dark:text-gray-300"></li>
                                </button>
                            </div>

                            {{-- Valores --}}
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if($option->pivot->features == [])
                                    <p class="text-gray-800 dark:text-gray-300 text-sm font-medium">Esta opción no tiene valores asociados, agrege valores para generar las variantes</p>
                                @else
                                    @foreach ($option->pivot->features as $feature)
                                        <div wire:key="option-{{$option->id}}-feature-{{$feature['id']}}">
                                            @switch($option->type)
                                                @case(1)
                                                    {{-- texto --}}
                                                    <span class="bg-gray-100 text-gray-800 text-sm font-medium me-2 pl-2.5 pr-1.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">
                                                        {{ $feature['description'] }}
        
                                                        <button class="ml-1 pt-0.5" onclick="confirmDelete({{$feature['id']}}, 'deleteFeature', {{$option->id}})">
                                                            <i class="fa-solid fa-xmark hover:text-red-600"></i>
                                                        </button>
        
                                                    </span>
                                                    @break
                                                @case(2)
                                                    {{-- color --}}
                                                    <div class="relative">
                                                        <span class="inline-block h-6 w-6 shadow-lg rounded-full border-2 border-gray-300 dark:border-gray-500 mr-4" style="background-color: {{ $feature['value'] }}"></span>
                                                        <button class="absolute z-10 left-4 -top-2" onclick="confirmDelete({{$feature['id']}}, 'deleteFeature', {{$option->id}})">
                                                            <i class="fa-solid fa-circle-xmark hover:text-red-500 dark:text-gray-300"></i>
                                                        </button>
                                                    </div>
                                                    @break
                                                @default 
                                            @endswitch
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div>
                                @livewire('admin.products.product-add-new-variants', ['option' => $option, 'product' => $product], key('product-add-new-variants-' . $option->id))
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @include('admin.partials.alert-info', ['message' => 'Cree las opciones, para poder generar las variantes'])
            @endif
        </div>
    </section>

    @if (!empty($option->pivot->features) && count($option->pivot->features) > 0)
        <section class="block border rounded-lg shadow-sm bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 mt-12">
            <header class="border-b px-6 py-2 border-gray-300 dark:border-gray-500">
                <div class="flex justify-between">
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Variantes
                    </h1>
                    <x-button>
                        <a href="{{route('admin.variants.create', [$product])}}">
                            Crear
                        </a>
                    </x-button>
                </div>
            </header>

            <div class="p-6">
                @if ($product->variants->isEmpty())
                    @include('admin.partials.alert-info', ['message' => 'Aún no se han generado variantes'])
                @else
                    <ul class="divide-y -my-4">
                        @foreach($product->variants as $item)
                            <li class="py-4 flex items-center">
                                <img src="{{ $item->images->first() ? Storage::url($item->images->first()->path) : asset('assets/img/no-image.png')}}" alt="" class="w-18 h-16 object-cover object-center">
                                
                                <p class="divide-x ml-2 text-gray-500 dark:text-gray-300">
                                    @foreach ($item->features as $featureItem)
                                        <span class="px-3">
                                            {{ $featureItem->description }}
                                        </span>
                                    @endforeach
                                </p>

                                <a href="{{ route('admin.variants.edit', [$product, $item]) }}" class="ml-auto font-medium text-yellow-600 dark:text-yellow-500">
                                    <i class="fa-solid fa-pen-to-square fa-2xl"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    @endif

    <x-dialog-modal wire:model="openModal">
        <x-slot name="title">
            Agregar una nueva opción
        </x-slot>

        <x-slot name="content">

            <x-validation-errors class="mb-4" />
            
            <div class="mb-4">
                <x-label class="mb-2">
                    Opción
                </x-label>

                <x-select wire:model.live="variant.option_id" wire:key="variant.optiond_id" class="w-full">
                    <option disabled selected value="">Seleccione una opción</option>
                    @foreach ($this->options as $option)
                        <option value="{{ $option->id }}">
                            {{ $option->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="flex items-center mb-6">
                <hr class="flex-1">
                <span class="mx-4">
                    Valores
                </span>
                <hr class="flex-1">
            </div>

            <ul class="mb-4 space-y-4">
                @foreach ($variant['features'] as $index => $feature)
                    <li wire:key="variant-feature-{{$index}}" 
                        class="relative rounded-lg border bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-6"
                        wire:change="featureChange({{$index}})">
                    
                        @if ($index != 0)
                            <div class="absolute -top-2 right-4 px-4 bg-white dark:bg-gray-800">
                                <button wire:click="removeFeature({{$index}})">
                                    <li class="fa-solid fa-trash-can hover:text-red-500 dark:text-gray-300"></li>
                                </button>
                            </div> 
                        @endif
                        
                        <div>
                            <x-label class="mb-2">
                                Valores
                            </x-label>

                            <x-select wire:key="feature-{{$index}}" wire:model="variant.features.{{$index}}.id" class="w-full">
                                <option disabled selected value="">Seleccione una opción</option>
                                @foreach ($this->features as $feature)
                                    <option value="{{ $feature->id }}">
                                        {{ $feature->description }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="flex justify-end">
                <x-button wire:click="addFeature">
                    Agregar Valor
                </x-button>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-blue" wire:click="save">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    @include('livewire.admin.partials.alert-destroy')
    
</div>

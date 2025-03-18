<div>
    <form action="" wire:submit="save">
        
        <x-validation-errors class="mb-4" />

        <div class="flex items-center mb-6 dark:text-gray-300 text-gray-800">
            <hr class="flex-1">
            <span class="mx-4">
                Seleccione los valores para su variante
            </span>
            <hr class="flex-1">
        </div>
        <ul class="mb-4 space-y-6">
            @foreach ($variants as $index => $variantItem)
                <li class="relative rounded-lg border bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-6">
                    @if ($index != 0)
                        <div class="absolute top-2 right-4 px-4 bg-white dark:bg-gray-800">
                            <button wire:click="removeFeature({{$index}})" type="button">
                                <li class="fa-solid fa-trash-can hover:text-red-500 dark:text-gray-300"></li>
                            </button>
                        </div> 
                    @endif
                    <div class="mb-4">
                        <x-label class="mb-2">
                            Opciones
                        </x-label>
                        
                        <x-select wire:model.live="variants.{{$index}}.option_id" wire:key="option-variant-{{$index}}" wire:change="resetFeatures({{$index}})">
                            <option value="" disabled selected>Seleccione una opción</option>
                            @foreach ($options as $option)
                                <option value="{{$option->id}}">
                                    {{$option->name}}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
            
                    <div>
                        <x-label class="mb-2">
                            Valor
                        </x-label>
            
                        <x-select wire:model="variants.{{$index}}.id" wire:key="feature-variant-{{$index}}">
                            <option value="" disabled selected>Seleccione una opción</option>
                            @foreach ($this->variantFeatures($index) as $itemfeature)
                                @foreach ($itemfeature->features as $feature)
                                    <option value="{{$feature['id']}}">
                                        {{$feature['description']}}
                                    </option>
                                @endforeach
                            @endforeach
                        </x-select>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="flex justify-end">
            <x-button wire:click="addFeature" type="button">
                Agregar Valor
            </x-button>
        </div>
        <div class="flex items-center mb-6 dark:text-gray-300 text-gray-800 mt-8">
            <hr class="flex-1">
            <span class="mx-4">
                Datos de la variante
            </span>
            <hr class="flex-1">
        </div>

        <div class="mb-6">
            <x-label class="mb-2">
                Stock
            </x-label>
            <x-input class="w-full" placeholder="Ingrese el stock del producto"
                type="number" wire:model="infoVariant.stock"/>
        </div>
        <h6 class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
            Imagen
        </h6>
        <div class="flex justify-center relative mt-4">
            <div class="absolute top-0 right-0 md:right-8">
                <label class="flex items-center btn2 btn-light cursor-pointer">
                    <i class="fa-solid fa-images fa-lg mr-2"></i>
                    Subir imagen
    
                    <input type="file" class="hidden" wire:model="image" accept="image/*">
                </label>
            </div>
            <figure class="max-w-lg">
                <img class="h-auto max-w-full" 
                src="{{ $image ? $image->temporaryUrl() : asset('assets/img/no-image.png') }}" alt="">
            </figure>
        </div>

        <div class="flex justify-end">
            <x-button>
                Guardar
            </x-button>
        </div>
    </form>
</div>

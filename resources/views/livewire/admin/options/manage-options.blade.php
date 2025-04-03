<div>
    <section class="block border rounded-lg shadow-sm bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700">

        <header class="border-b px-6 py-2 border-gray-300 dark:border-gray-500">
            <div class="flex justify-between">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Opciones
                </h1>

                <x-button wire:click="$set('newOption.openModal', true)">
                    Crear
                </x-button>
            </div>
        </header>

        <div class="p-6">
            @if (count($options))
                <div class="space-y-6">
                    @foreach ($options as $option)
                        <div class="p-6 rounded-lg border border-gray-300 dark:border-gray-500 relative" wire:key="option-{{$option->id}}">
                            <div class="absolute -top-3 bg-white dark:bg-gray-800">
                                <span class="text-gray-500 dark:text-gray-400 px-3">
                                    {{ $option->name }}
                                </span>
                                <button class="mr-3" onclick="confirmDelete({{$option->id}}, 'deleteOption')">
                                    <li class="fa-solid fa-trash-can hover:text-red-500 dark:text-gray-300"></li>
                                </button>
                            </div>
                            
                            @if ($option->features->isEmpty())
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <p class="text-gray-800 dark:text-gray-300 text-sm font-medium">Esta opción no tiene valores asociados</p>
                                </div>
                            @else
                                {{-- Valores --}}
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach ($option->features as $feature)
                                        @switch($option->type)
                                            @case(1)
                                                {{-- texto --}}
                                                <span class="bg-gray-100 text-gray-800 text-sm font-medium me-2 pl-2.5 pr-1.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">
                                                    {{ $feature->description }}

                                                    <button class="ml-1 pt-0.5" onclick="confirmDelete({{$feature->id}}, 'deleteFeature')">
                                                        <i class="fa-solid fa-xmark hover:text-red-600"></i>
                                                    </button>

                                                </span>
                                                @break
                                            @case(2)
                                                {{-- color --}}
                                                <div class="relative">
                                                    <span class="inline-block h-6 w-6 shadow-lg rounded-full border-2 border-gray-300 dark:border-gray-500 mr-4" style="background-color: {{ $feature->value }}"></span>
                                                    <button class="absolute z-10 left-4 -top-2" onclick="confirmDelete({{$feature->id}}, 'deleteFeature')">
                                                        <i class="fa-solid fa-circle-xmark hover:text-red-500 dark:text-gray-300"></i>
                                                    </button>
                                                </div>
                                                @break
                                            @default 
                                        @endswitch
                                    @endforeach
                                </div>
                            @endif

                            <div>
                                @livewire('admin.options.add-new-features', ['option' => $option], key('add-new-feature-' . $option->id))
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @include('admin.partials.alert-info', ['message' => 'Aún no se han registrado opciones para los productos'])
            @endif
        </div>
    </section>

    <x-dialog-modal wire:model="newOption.openModal">
        <x-slot name="title">
            Crear una nueva opción
        </x-slot>

        <x-slot name="content">

            <x-validation-errors class="mb-4" />
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <x-label class="mb-2">
                        Nombre:
                    </x-label>
                    
                    <x-input  wire:model="newOption.name" class="w-full" placeholder="Por ejemplo: Material, Color"/>
                </div>

                <div>
                    <x-label class="mb-2">
                        Tipo:
                    </x-label>

                    <x-select wire:model.live="newOption.type" wire.key="option-type" class="w-full">
                        <option value="" disabled selected>Seleccione </option>
                        <option value="1">Texto</option>
                        <option value="2">Color</option>
                    </x-select>
                </div>
            </div>

            <div class="flex items-center mb-4">
                <hr class="flex-1">
                <span class="mx-3">
                    Valores
                </span>
                <hr class="flex-1">
            </div>

            <div class="mb-4 space-y-4">
                @foreach ($newOption->features as $index => $feature)
                    <div class="p-6 rounded-lg border bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 relative" 
                        wire:key="features-{{$index}}">

                        @if ($index != 0)
                            <div class="absolute -top-2 px-4 -right-0">
                                <button wire:click="removeFeature({{ $index }})">
                                    <i class="fa-solid fa-rectangle-xmark fa-2xl text-red-600 hover:text-red-500 dark:text-red-500 dark:hover:text-red-600"></i>
                                </button>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-label class="mb-2">
                                    Valor:
                                </x-label>
                                
                                @switch($newOption->type)
                                    @case(1)
                                        
                                        <x-input wire:model="newOption.features.{{ $index }}.value" class="w-full" placeholder="Ingrese el valor de la opción"/>

                                        @break
                                    @case(2)
                                        
                                        <div class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300  rounded-md shadow-sm h-[42px] flex items-center px-3 justify-between">
                                            
                                            {{ $newOption->features[$index]['value'] ?: 'Seleccione un color'}}

                                            <input type="color" wire:model.live="newOption.features.{{ $index }}.value" class="focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                        </div>

                                        @break
                                    @default
                                        <div class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300  rounded-md shadow-sm h-[42px] flex items-center px-3 justify-between">
                                            <p>Seleccione un tipo primero</p>
                                        </div>
                                @endswitch
                                
                            </div>
                            
                            <div>
                                <x-label class="mb-2">
                                    Descripción:
                                </x-label>
                                
                                <x-input wire:model="newOption.features.{{ $index }}.description" class="w-full" placeholder="Ingrese una descripción"/>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end">
                <x-button wire:click="addFeature">
                    Agregar valor
                </x-button>
            </div>
        </x-slot>

        <x-slot name="footer">

            <button class="btn btn-blue" wire:click="storeOption">
                Guardar
            </button>

        </x-slot>
    </x-dialog-modal>

    @include('livewire.admin.partials.alert-destroy')

</div>

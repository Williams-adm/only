<div class="card card-color">
    <form wire:submit="save">
        <x-validation-errors class="mb-4" />

        <div class="mb-4">
            <x-label class="mb-2">
                Familias
            </x-label>

            <x-select wire:model.live="family_id" wire:key="family-select-{{ $family_id }}" class="w-full">
                <option disabled value="">Selecciona una familia </option>
                @foreach ($families as $family)
                    <option value="{{ $family->id }}">
                        {{ $family->name }}
                    </option>
                @endforeach
            </x-select>
        </div>
        
        <div class="mb-4">
            <x-label class="mb-2">
                Categorías
            </x-label>

            <x-select wire:model.live="category_id" wire:key="category-select-{{ $family_id }}-{{ $category_id }}" class="w-full">
                <option disabled value="">Selecciona una categoría </option>
                @foreach ($this->categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </x-select>
        </div>
        
        <div class="mb-4">
            <x-label class="mb-2">
                SubCategorías
            </x-label>
            
            <x-select wire:model.live="sub_category_id" wire:key="subcategory-select-{{ $family_id }}-{{ $category_id }}-{{ $sub_category_id }}" class="w-full">
                <option disabled value="">Selecciona una subcategoría </option>
                @foreach ($this->subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">
                        {{ $subcategory->name }}
                    </option>
                @endforeach
            </x-select>
        </div>
    
        <div class="mb-4">
            <x-label class="mb-2">
                Nombre
            </x-label>
            <x-input class="w-full" placeholder="Ingrese el nombre del producto" wire:model="name" wire:key="name"/>
        </div>
    
        <div class="mb-4">
            <x-label class="mb-2">
                Descripción
            </x-label>
            <x-textarea wire:model="description" placeholder="Ingrese una descripción para el producto" rows="4">
            </x-textarea>
        </div>

        <div class="flex justify-end">
            <x-button>
                Guardar
            </x-button>
        </div>
    </form>
</div>

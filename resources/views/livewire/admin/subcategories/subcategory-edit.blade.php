<div class="card card-color">
    <form>

        <x-validation-errors class="mb-4" />

        <div class="mb-4">
            <x-label class="mb-2">
                Categorias
            </x-label>

            <x-select name="category_id" wire:model.live="category_id" wire:key="category-select-{{ $category_id }}" class="w-full">
                <option disabled selected value="">Selecciona una categoría </option>
                @foreach ($this->categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </x-select>
        </div>

        <div class="mb-4">
            <x-label class="mb-2">
                Nombre
            </x-label>
            <x-input class="w-full" placeholder="Ingrese el nombre de la subcategoría"
                wire:model="name" />
        </div>
        <div class="flex justify-end">
            <x-button type="button" onclick="confirmEdit()">
                Actualizar
            </x-button>
        </div>
    </form>

    @push('js')
        <script>
            function confirmEdit() {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, actualizar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('save');
                    }
                });
            }
        </script>
    @endpush
</div>

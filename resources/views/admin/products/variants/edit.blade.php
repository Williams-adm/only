<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos',
        'route' => route('admin.products.index'),
    ],
    [
        'name' => $product->name,
        'route' => route('admin.products.show', $product->id),
    ],
    [
        'name' => 'variante - ' . $variant->features->pluck('description')->implode(' | '),
    ],
]">

    <form action="{{route('admin.variants.update', [$product, $variant])}}" method="POST"
        enctype="multipart/form-data" id="edit-form">
        @csrf
        @method('PATCH')

        <x-validation-errors class="mb-4" />

        <h6 class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
            Imagen
        </h6>
        <div class="flex justify-center relative mt-4">
            <div class="absolute top-0 right-0 md:right-8">
                <label class="flex items-center btn2 btn-light cursor-pointer">
                    <i class="fa-solid fa-images fa-lg mr-2"></i>
                        Subir imagen
                    <input type="file" class="hidden" accept="image/*" name="image"
                    onchange="previewImage(event, '#imgPreview')">
                </label>
            </div>
            <figure class="max-w-lg">
                <img class="h-auto max-w-full" 
                    src="{{ old('old_image', $variant->images->first() ? Storage::url($variant->images->first()->path) : asset('assets/img/no-image.png')) }}"  
                    alt="" id="imgPreview">
            </figure>
            <input type="hidden" name="old_image" value="{{ old('old_image', $variant->images->first() ? Storage::url($variant->images->first()->path) : asset('assets/img/no-image.png')) }}">
        </div>

        <div class="mb-4">
            <x-label class="mb-2">
                    Stock
            </x-label>
            <x-input class="w-full" type="number" name="stock"
                value="{{ old('stock', $variant->stock) }}"
                placeholder="Ingrese el stock" 
            />
        </div>
        
        <div class="mb-4">
            <x-label class="mb-2">
                    Precio
            </x-label>
            <x-input class="w-full" type="number" name="price"
                value="{{ old('price', $variant->price) }}"
                placeholder="Ingrese el precio" 
            />
        </div>

        <div class="flex justify-end">
            <x-button type="button" onclick="confirmEdit()">
                Actualizar
            </x-button>
        </div>
    </form>

    @include('admin.partials.sweet-alert-edit')

    @push('js')
        <script>
            function previewImage(event, querySelector){
	            //Recuperamos el input que desencadeno la acción
	            const input = event.target;
	
	            //Recuperamos la etiqueta img donde cargaremos la imagen
	            $imgPreview = document.querySelector(querySelector);

                const oldImageInput = document.querySelector('input[name="old_image"]');
	            // Verificamos si existe una imagen seleccionada
	            if(!input.files.length) return
	
	            //Recuperamos el archivo subido
	            file = input.files[0];

	            //Creamos la url
	            objectURL = URL.createObjectURL(file);
	
	            //Modificamos el atributo src de la etiqueta img
	            $imgPreview.src = objectURL;

                oldImageInput.value = objectURL;
        
            }
        </script>
    @endpush
</x-admin-layout>
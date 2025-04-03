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
        'name' => $data->name,
    ],
]">

    <section class="mb-8">
        <h5 class="text-center header-h5 mb-4">Detalles del Producto</h5>

        <div>
            <div class="mb-3">
                <h6 class="header-h6">
                    Sku:
                </h6>
                <p class="text-gray-500 dark:text-gray-300">
                    {{ $data->sku }}
                </p>
            </div>

            <div class="mb-3">
                <h6 class="header-h6">
                    Familia:
                </h6>
                <p class="cont-p">
                    {{ $data->subCategory->category->family->name }}
                </p>
            </div>

            <div class="mb-3">
                <h6 class="header-h6">
                    Categoría:
                </h6>
                <p class="cont-p">
                    {{ $data->subCategory->category->name }}
                </p>
            </div>

            <div class="mb-3">
                <h6 class="header-h6">
                    SubCategoría:
                </h6>
                <p class="cont-p">
                    {{ $data->subCategory->name }}
                </p>
            </div>

            <div class="mb-3">
                <h6 class="header-h6">
                    Nombre:
                </h6>
                <p class="cont-p">
                    {{ $data->name }}
                </p>
            </div>
            
            <div class="mb-3">
                <h6 class="header-h6">
                    Descripción:
                </h6>
                <p class="cont-p">
                    {{ $data->description }}
                </p>
            </div>
        </div>
    </section>

    <h5 class="text-center header-h5 mb-6">Generar Variantes</h5>

    @livewire('admin.products.product-variants', ['product' => $data])

</x-admin-layout>

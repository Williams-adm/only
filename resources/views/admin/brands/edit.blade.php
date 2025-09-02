<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Marcas',
        'route' => route('admin.brands.index'),
    ],
    [
        'name' => 'Editar - ' . $data->name,
    ],
]">

    <div class="card card-color">
        <form action="{{ route('admin.brands.update', $data) }}" method="POST" id="edit-form">
            @csrf
            @method('PUT')

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label class="mb-2">
                    Nombre
                </x-label>
                <x-input class="w-full"
                    placeholder="Ingrese el nombre de la marca"
                    name="name" value="{{ old('name', $data->name) }}"/>
            </div>
            <div class="flex justify-end">
                <x-button type="button" onclick="confirmEdit()">
                    Actualizar
                </x-button>
            </div>
        </form>
    </div>

    @include('admin.partials.sweet-alert-edit')

</x-admin-layout>
